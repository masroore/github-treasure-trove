<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\CTUser;
use App\Models\User;
use App\Models\UserBalance;
use App\Providers\RouteServiceProvider;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        $gender_list = config('constants.gender_list');
        $data['gender_list'] = $gender_list;

        $country_list = $this->getCountryList();
        $data['country_list'] = $country_list;

        $language_list = config('constants.language_list');
        $data['language_list'] = $language_list;

        return view('auth.register', $data);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'login_id' => ['required', 'alpha_dash', 'max:128',
                Rule::unique('ct_users')->where(function ($query) use ($data) {
                    return $query->where('login_id', $data['login_id']);
                }), ],
            'name' => ['required', 'string', 'max:128'],
            'email' => ['required', 'string', 'email', 'max:128',
                Rule::unique('ct_users')->where(function ($query) use ($data) {
                    return $query->where('email', $data['email']);
                }), ],
            'password' => ['required', 'string', 'min:8', 'max:255', 'confirmed'],
            'birthday' => ['nullable', 'date'],
            'mobile' => ['required', 'string', 'max:20'],
            'country' => ['required', 'string', 'max:64'],
            'lang' => ['required', 'string', 'max:4'],
            'address' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:16'],
        ], [
        ], [
            'login_id' => trans('register.login_id'),
            'name' => trans('register.name'),
            'email' => trans('register.email'),
            'password' => trans('register.password'),
            'birthday' => trans('register.birthday'),
            'mobile' => trans('register.mobile'),
            'country' => trans('register.country'),
            'lang' => trans('register.lang'),
            'address' => trans('register.address'),
            'postal_code' => trans('register.postal_code'),
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'login_id' => $data['login_id'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'birthday' => date('Y-m-d', strtotime($data['birthday'])),
            'gender' => $data['gender'],
            'mobile' => $data['mobile'],
            'country' => $data['country'],
            'lang' => $data['lang'],
            'address' => $data['address'],
            'postal_code' => $data['postal_code'],
            'status' => config('constants.user_status.invalid'),
        ]);
    }

    protected function registered(Request $request, $user): void
    {
        $user = Auth::user();

        $cryptocurrency_list = $this->getCryptocurrencyList();

        $insert_data = [];
        foreach ($cryptocurrency_list as $cryptocurrency_info) {
            if ($cryptocurrency_info['use_deposit'] == config('constants.use_deposit.enable')) {
                $insert_data[] = [
                    'user_id' => $user->id,
                    'currency' => $cryptocurrency_info['currency'],
                    'balance' => 0,
                    'status' => config('constants.balance_status.valid'),
                ];
            }
        }

        try {
            UserBalance::insert($insert_data);
            /*            CTUser::insert([
                            'id' => $user->id,
                            'login_id' => $user->login_id,
                            'email' => $user->email,
                            'name' => $user->name,
                            'birthday' => $user->birthday,
                            'gender' => $user->gender,
                            'country' => $user->country,
                            'mobile' => $user->mobile,
                            'postal_code' => $user->postal_code,
                            'address' => $user->address,
                            'avatar' => $user->avatar,
                        ]);*/
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            print_r($e->getMessage());
            exit();
        }
    }
}
