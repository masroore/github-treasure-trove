<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\Identity;
use App\Models\LoginHistory;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $gender_list = config('constants.gender_list');
        $data['gender_list'] = $gender_list;

        $country_list = $this->getCountryList();
        $data['country_list'] = $country_list;

        $language_list = config('constants.language_list');
        $data['language_list'] = $language_list;

        $user = Auth::user();

        $google2fa = app('pragmarx.google2fa');
        $google2fa_secret = $google2fa->generateSecretKey();
        $QR_Image = $google2fa->getQRCodeInline(
            config('app.name'),
            $user->email,
            $google2fa_secret
        );

        $kyc_list = $this->getKYCInfo();

        $data['google2fa_secret'] = $google2fa_secret;
        $data['google2fa_qr_img'] = $QR_Image;
        $data['kyc_list'] = $kyc_list;

        return view('setting', $data);
    }

    /**
     * update user profile.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'avatar' => ['nullable', 'mimes:jpg,bmp,jpeg,png'],
            'name' => ['required', 'string', 'max:128'],
            'birthday' => ['nullable', 'date'],
            'mobile' => ['required', 'string', 'max:20'],
            'country' => ['required', 'string', 'max:64'],
            'address' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:16'],
        ], [
        ], [
            'avatar' => trans('setting.avatar'),
            'name' => trans('setting.name'),
            'birthday' => trans('setting.birthday'),
            'mobile' => trans('setting.mobile'),
            'country' => trans('setting.country'),
            'address' => trans('setting.address'),
            'postal_code' => trans('setting.postal_code'),
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();

            return redirect()->back()->withInput()->withErrors($errors);
        }

        $user = Auth::user();

        if (isset($data['avatar'])) {
            $fileName = $user->login_id . '.' . $request->avatar->extension();

            $request->avatar->move(public_path('uploads/avatar'), $fileName);
            $avatar = url('uploads/avatar') . '/' . $fileName;
        } else {
            $avatar = $user->avatar;
        }

        try {
            $user->avatar = $avatar;
            $user->name = $data['name'];
            $user->birthday = date('Y-m-d', strtotime($data['birthday']));
            $user->mobile = $data['mobile'];
            $user->country = $data['country'];
            $user->address = $data['address'];
            $user->postal_code = $data['postal_code'];
            $user->save();
        } catch (QueryException $e) {
            Log::error($e->getMessage());

            return redirect()->back()->withInput()->withErrors(['failed' => trans('setting.profile_failed_msg')]);
        }

        return redirect()->route('setting')->with('success', trans('setting.profile_success_msg'));
    }

    /**
     * id verify.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function idVerify(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'id_doc.*' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
        ], [
            'id_doc.*' => trans('setting.id_doc'),
        ]);

        $data = $request->all();
        if (!isset($data['id_doc'])) {
            return redirect()->back()->withInput()->withErrors(['failed' => trans('setting.id_failed_msg'), 'id_failed' => trans('setting.id_failed_msg')]);
        }

        if (isset($data['id_doc_id'])) {
            $id_list = $data['id_doc_id'];
        } else {
            $id_list = [];
        }

        $id_files = $data['id_doc'];
        $insert_data = [];

        try {
            foreach ($id_files as $id_file) {
                $key = array_search($id_file, $id_files);
                $fileName = $user->login_id . $key . '.' . $id_file->extension();

                $id_file->move(public_path('uploads/kyc'), $fileName);
                $photo_url = url('uploads/kyc') . '/' . $fileName;

                if (isset($id_list[$key])) {
                    Identity::where('id', $id_list[$key])
                        ->update(['photo_url' => $photo_url]);
                } else {
                    $insert_data[] = [
                        'user_id' => $user->id,
                        'photo_url' => $photo_url,
                    ];
                }
            }

            Identity::insert($insert_data);

            $user->kyc_status = config('constants.kyc_status.review');
            $user->save();
        } catch (QueryException $e) {
            Log::error($e->getMessage());

            return redirect()->back()->withInput()->withErrors(['failed' => trans('setting.id_failed_msg'), 'id_failed' => trans('setting.id_failed_msg')]);
        }

        return redirect()->route('setting')->with('success', trans('setting.id_success_msg'))->with('id_success', trans('setting.id_success_msg'));
    }

    /**
     * delete id verify doc.
     */
    public function idVerifyDelete(Request $request): void
    {
        $id = $request->input('id');

        $status = 0;

        if (null === $id) {
            echo json_encode($status);
            exit;
        }

        try {
            Identity::where('id', $id)->delete();
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            echo json_encode($status);
            exit;
        }
        $status = 1;

        echo json_encode($status);
    }

    /**
     * update password.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ], [
        ], [
            'current_password' => trans('setting.current_pwd'),
            'password' => trans('setting.new_pwd'),
            'password_confirmation' => trans('setting.new_pwd_confirm'),
        ]);

        $user = Auth::user();

        if (!Hash::check($data['current_password'], $user->password)) {
            $validator->errors()->add('current_password', trans('setting.current_pwd_wrong'));
            $errors = $validator->errors();

            return redirect()->back()->withInput()->withErrors($errors);
        }

        if ($validator->fails()) {
            $errors = $validator->errors();

            return redirect()->back()->withInput()->withErrors($errors);
        }

        try {
            $user->password = Hash::make($data['password']);
            $user->save();
        } catch (QueryException $e) {
            Log::error($e->getMessage());

            return redirect()->back()->withInput()->withErrors(['failed' => trans('setting.pwd_failed_msg'), 'pwd_failed' => trans('setting.pwd_failed_msg')]);
        }

        return redirect()->route('setting')->with('success', trans('setting.pwd_success_msg'))->with('pwd_success', trans('setting.pwd_success_msg'));
    }

    /**
     * enable 2FA google auth.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function enable2FA(Request $request)
    {
        $user = Auth::user();

        $google2fa_secret = $request->input('google2fa_secret');
        $verification_code = $request->input('verification_code');

        $google2fa = app('pragmarx.google2fa');
        $valid = $google2fa->verifyKey($google2fa_secret, $verification_code);

        if ($valid) {
            try {
                $user->use_google_auth = config('constants.step_auth_status.use');
                $user->google2fa_secret = $google2fa_secret;
                $user->save();
            } catch (QueryException $e) {
                return redirect()->back()->withInput()->withErrors(['failed' => trans('setting.2fa_failed_msg'), '2fa_failed' => trans('setting.2fa_failed_msg')]);
            }
        } else {
            return redirect()->back()->withInput()->withErrors(['failed' => trans('setting.2fa_failed_msg'), '2fa_failed' => trans('setting.2fa_failed_msg')]);
        }

        return redirect()->route('setting')->with('success', trans('setting.2fa_success_msg'))->with('2fa_success', trans('setting.2fa_success_msg'));
    }

    /**
     * disable 2FA google auth.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function disable2FA(Request $request)
    {
        $user = Auth::user();

        try {
            $user->use_google_auth = config('constants.step_auth_status.no_use');
            $user->google2fa_secret = '';
            $user->save();
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors(['failed' => trans('setting.2fa_failed_msg'), '2fa_failed' => trans('setting.2fa_failed_msg')]);
        }

        return redirect()->route('setting')->with('success', trans('setting.2fa_success_msg'))->with('2fa_success', trans('setting.2fa_success_msg'));
    }

    /**
     * get data list.
     */
    public function getDataList(Request $request): void
    {
        $data_list = [];

        try {
            $data_list = Data::leftjoin('ct_datas_files', 'ct_datas_files.data_id', '=', 'ct_datas.id')
                ->where('ct_datas.status', config('constants.data_status.valid'))
                ->select('ct_datas.*', 'ct_datas_files.url', 'ct_datas_files.file_name')
                ->orderby('ct_datas.updated_at', 'desc')
                ->get()->toArray();
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            echo json_encode($data_list);
            exit;
        }

        echo json_encode($data_list);
    }

    /**
     * get login history.
     */
    public function getLoginHistory(Request $request): void
    {
        $user = Auth::user();

        $login_history = [];

        try {
            $login_history = LoginHistory::where('user_id', $user->id)
                ->get()->toArray();
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            echo json_encode($login_history);
            exit;
        }

        echo json_encode($login_history);
    }

    /**
     * update language setting.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function language(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'lang' => 'required',
        ], [
        ], [
            'lang' => trans('setting.language'),
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();

            return redirect()->back()->withInput()->withErrors($errors);
        }

        $user = Auth::user();

        $user->lang = $data['lang'];

        try {
            $user->save();
            App::setLocale($data['lang']);
            session()->put('locale', $data['lang']);
        } catch (QueryException $e) {
            Log::error($e->getMessage());

            return redirect()->back()->withInput()->withErrors(['failed' => trans('setting.lang_failed_msg'), 'language' => trans('setting.lang_failed_msg')]);
        }

        return redirect()->route('setting')->with('success', trans('setting.lang_success_msg'))->with('language', trans('setting.lang_success_msg'));
    }
}
