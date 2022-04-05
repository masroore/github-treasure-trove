<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\LoginHistory;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use hisorange\BrowserDetect\Parser as Browser;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Stevebauman\Location\Facades\Location;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    protected $username;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');

        $this->username = $this->findUsername();
    }

    public function findUsername()
    {
        $login = request()->input('login');

        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'login_id';

        request()->merge([$fieldType => $login]);

        return $fieldType;
    }

    public function username()
    {
        return $this->username;
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function attemptLogin(Request $request)
    {
        $credential = $this->credentials($request);

        return $this->guard()->attempt(
            $credential,
            $request->filled('remember')
        );
    }

    protected function authenticated(Request $request, $user)
    {
        $user = Auth::user();

        App::setLocale($user->lang);
        session()->put('locale', $user->lang);

        if ($user->use_google_auth == config('constants.step_auth_status.use')) {
            Auth::logout();

            $request->session()->put('2fa:user:id', $user->id);

            return redirect()->route('2fa');
        }

        $ip = $request->getClientIp();

        $device = config('constants.device.Unknown');
        if (Browser::isDesktop()) {
            $device = config('constants.device.Desktop');
        } elseif (Browser::isMobile()) {
            $device = config('constants.device.Mobile');
        } elseif (Browser::isTablet()) {
            $device = config('constants.device.Tablet');
        }

        $platform = Browser::browserFamily();

        $position = Location::get();
        $region = $position->countryName . ' ' . $position->cityName;

        $res = LoginHistory::create([
            'user_id' => $user->id,
            'ip_addr' => $ip,
            'device' => $device,
            'platform' => $platform,
            'region' => $region,
            'accessed_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function getValidateToken()
    {
        if (session('2fa:user:id')) {
            return view('auth/2favalidate');
        }

        return redirect('login');
    }

    public function postValidateToken(Request $request)
    {
        //get user id and create cache key
        $userId = $request->session()->pull('2fa:user:id');
        $request->session()->put('2fa:user:id', $userId);
        $data = $request->all();

        $validator = Validator::make($data, [
            'verification_code' => 'required',
        ], [
        ], [
            'verification_code' => trans('login.2fa_code'),
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();

            return redirect()->back()->withInput()->withErrors($errors);
        }

        $verification_code = $data['verification_code'];

        try {
            $user = User::where('id', $userId)->first();
            if (null === $user) {
                $validator->errors()->add('verification_code', trans('login.2fa_failed_msg'));
                $errors = $validator->errors();

                return redirect()->back()->withInput()->withErrors($errors);
            }

            $google2fa_secret = $user->google2fa_secret;

            $google2fa = app('pragmarx.google2fa');
            $valid = $google2fa->verifyKey($google2fa_secret, $verification_code);

            if (!$valid) {
                $validator->errors()->add('verification_code', trans('login.2fa_failed_msg'));
                $errors = $validator->errors();

                return redirect()->back()->withInput()->withErrors($errors);
            }
        } catch (QueryException $e) {
            $validator->errors()->add('verification_code', trans('login.2fa_failed_msg'));
            $errors = $validator->errors();

            return redirect()->back()->withInput()->withErrors($errors);
        }

        //login and redirect user
        Auth::loginUsingId($userId);

        return redirect()->intended($this->redirectTo);
    }
}
