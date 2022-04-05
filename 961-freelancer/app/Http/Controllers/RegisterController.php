<?php

namespace App\Http\Controllers;

use App\Models\Countries;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;
use Redirect;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    // Route
    public function forgotPasswordRoute()
    {
        return view('frontend.forgot-password');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }

    // Check Username
    public function usernameCheck(Request $request)
    {
        $check = User::where('username', $request->username)->first();
        // dd($check);
        if ($check) {
            return response()->json(['status' => 'true', 'message' => 'username already exists, try another one'], 200);
        }

        return response()->json(['status' => 'errorr', 'message' => 'you can use this as your username'], 200);
    }

    public function register(Request $request)
    {
        if ($request->isMethod('post')) {
            $get_user = User::whereusername($request->input('username'))->first();
            if ('' != $get_user) {
                $request->session()->flash('loginAlert', 'Username Already Taken');

                return redirect('/login');
            }
            $this->validate($request, [
                'mobile_number' => 'required|min:2|max:32',
                'email' => 'required|email|unique:users,email',
                'username' => 'required|unique:users,username',
                'password' => 'required|min:5|max:50',
                'account_type' => 'required',
                'age' => 'required',

            ], [

                'email.unique' => 'Email must be unique',
                'email.required' => 'Enter Email',
                'mobile_number.required' => 'Enter Mobile Number',
                'address.required' => 'Enter Address',
                'password.required' => 'Enter password',
                'account_type.required' => 'Select you account type',
                'age.required' => 'Please enter your date of birth',
            ]);

            // save User
            $user = new User();
            $user->username = $request->input('username');
            $user->email = $request->input('email');
            $user->age = $request->input('age');
            // $full_number = str_replace('+','',$request->input('full'));
            // $country_code = str_replace($request->input('mobile_number'),'',$full_number);
            // $mobile_number = $request->input('mobile_number');
            // $country = Countries::where('phonecode',$country_code)->orwhere('phonecode','+'.$country_code)->first()->name;
            // $country_code = str_replace($request->input('phone_code'),'',$full_number);
            $country = $request->input('country');
            $mobile_number = $request->input('phone_code') . $request->input('mobile_number');
            // $country = Countries::where('phonecode',$country_code)->orwhere('phonecode','+'.$country_code)->first()->name;
            // dd($mobile_number);
            // dd($request->all(),$full_number,$country_code,$country);
            $user->mobile_number = $mobile_number;
            $user->country = $country;
            $user->remember_token = $request->input('_token');
            $user->password = Hash::make(trim($request->input('password')));
            $user->user_status = 'online';
            $user->verification = 0;
            $user->account_type = $request->input('account_type');
            $user->status = 'active';
            // $slug = $this->createSlug($request->input('username'));
            // $user->slug = $slug;
            $user->save();
            $user->id;
            $new_user = User::find($user->id);
            // dd($new_user);

            $toemail = $new_user->email;
            // dd($toemail);
            Mail::send(
                'mail.user-registration-email',
                ['user' => $new_user],
                function ($message) use ($toemail): void {
                    $message->subject('961Freelancer - Verify Account');
                    $message->from('support@961freelancer.com', '961Freelancer');
                    $message->to($toemail);
                }
            );

            return redirect()->back()->with('registerSuccess', 'Account created. Please check your email.');

            // return redirect('login');
        }
        $countries = Countries::get();

        return view('frontend.signup', compact('countries'));
    }

    ///////////////////// Account Verify //////////////////////////////
    public function VerifyAccount(Request $request, $username, $token)
    {
        $user = User::where('username', $username)->where('remember_token', $token)->first();
        // dd($user);
        $user->verification = 1;
        $user->save();
        $request->session()->flash('verify_success', 'Email verified.');

        return redirect('login');
    }

    // Login Function
    public function checkLogin(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);
        $user_data = [
            'username' => $request->get('username'),
            'password' => $request->get('password'),
        ];

        if (!Auth::attempt($user_data)) {
            $user_data2 = [
                'email' => $request->get('username'),
                'password' => $request->get('password'),
            ];
            if (!Auth::attempt($user_data2)) {
                $request->session()->flash('loginAlert', 'Invalid Email & Password');

                return redirect('login');
            }
        }
        $next = $request->input('next');
        // dd($next,$package_id);
        if (Auth::check()) {
            $user_id = auth()->user()->id;
            $update_status = User::where('id', $user_id)->update(['user_status' => 'online']);
            if (null != $next) {
                if (null != $package_id) {
                    return redirect($next)->with(['package_id' => $package_id]);
                }

                return redirect($next);
            }
            if ($request->session()->has('previous_url')) {
                $url = $request->session()->get('previous_url');
                session()->forget('previous_url');

                return redirect($url);
            }
            if ('Freelancer' == auth()->user()->account_type) {
                return redirect('dashboards');
            }

            return redirect('dashboard');
        }
    }

    public function accountLogin(Request $request)
    {
        if (Auth::check()) {
            if ($request->session()->has('previous_url')) {
                $url = $request->session()->get('previous_url');
                session()->forget('previous_url');

                return redirect($url);
            }

            return redirect('profile');
        }

        return view('frontend.signin');
    }

    // Logout
    public function logout(Request $request)
    {
        $user_id = auth()->user()->id;
        $update_status = User::where('id', $user_id)->update(['user_status' => 'offline']);
        Auth::logout();
        $request->session()->flash('u_session');

        return redirect('login');
    }

    // Reset Password
    public function sendResetLinkEmail(Request $request)
    {
        if ($request->isMethod('post')) {
            $email = $request->input('email');
            $string = mt_rand(5, 999999999);
            // $remember_token = $request->input('_token');

            $new_user = User::whereemail($email)->first();

            if ('' == $new_user) {
                $request->session()->flash('resetAlert', "We can't find a user with that e-mail address.");
            // return redirect()->back()->with("error","Please Enter Correct Email");
            } else {
                $dataArr['remember_token'] = $string;

                $dataUser = User::where('email', $email)
                    ->update($dataArr);
                //dd($dataUser);
                $userData = User::whereemail($email)->first();
                //dd($userdata, $remember_token);
                $toemail = $userData->email;
                Mail::send(
                    'mail.forgotpassword-email',
                    ['user' => $userData],
                    function ($message) use ($toemail): void {
                        $message->subject('961Freelancer - Forgot Password');
                        $message->from('support@961freelancer.com', '961Freelancer');
                        $message->to($toemail);
                    }
                );

                $request->session()->flash('resetSuccess', 'Check your Email to change your password.');
            }

            return redirect('/forgot-password');
        }
    }

    public function showPasswordResetForm(Request $request, $email, $token)
    {
        // dd($email, $token);

        $usersData = User::where('email', $email)->where('remember_token', $token)->first();
        // dd($usersData);

        if ('' == $usersData) {
            $request->session()->flash('resetAlert', "Your secret code don't match please contact to Admin.");

            return redirect('/forgot-password');
        }

        return view('frontend.change-password', compact('usersData'));
    }

    public function resetPassword(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|min:5|max:50|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'min:5',
        ]);
        $user_id = $request->input('user_id');
        $pass = Hash::make(trim($request->input('password')));
        $user = User::whereid($user_id)->update(['password' => $pass]);
        $request->session()->flash('passwordSuccess', 'Password changed successfully');
        Auth::logout();

        return redirect('/login');
    }
}
