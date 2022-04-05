<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

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
    protected $maxAttempts = 3; // default is 5

    protected $decayMinutes = 1; // default is 1

    // protected $redirectTo;
    public function redirectTo()
    {
        return redirect()->route('admindashboard');

        return $next($request);
    }

    // protected $redirectTo = '/';

    public function showLoginForm(Request $request)
    {
        if (auth::check()) {
            $role_name = Auth::user()->getRoleNames()->first();

            if ($role_name == 'User') {
                return redirect()->route('userdashboard');
            } elseif ($role_name == 'Owner') {
                return redirect()->route('ownerdashboard');
            }

            Auth::logout();

            return redirect()->route('login')->with('status', 'error')->with('message', Config::get('constants.ERROR.WRONG_CREDENTIAL'));
        }

        if (!session()->has('url.intended')) {
            session(['url.intended' => url()->previous()]);
        }
        if ($request->has('register')) {
            $register = Config::get('constants.SUCCESS.ACCOUNT_CREATED');
        } else {
            $register = '';
        }

        return view('auth.login', compact('register'));
    }

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request): void
    {
        $user = User::where('email', $request->email)->where('status', 0)->orWhere('is_deleted', 1)->first();

        if (empty($user)) {

        // $credentials = array_merge($request->only($this->username(), 'password'), ['status' => 1, 'is_deleted' => 0]);
            $credentials = $request->only($this->username(), 'password');

            $authSuccess = Auth::attempt($credentials);

            if ($authSuccess) {
                $role_name = Auth::user()->getRoleNames()->first();

                if ($role_name == 'User') {
                    $url = route('home');
                    $data = ['success' => true, 'message' => $url];
                } elseif ($role_name == 'Owner') {
                    $url = route('home');
                    $data = ['success' => true, 'message' => $url];
                } else {
                    Auth::logout();
                    $data = ['success' => true,
                        'message' => route('login'), ];
                }
                // $data = ['success' => true,
            // 'message' => $url ];
            } else {
                $data = ['success' => false,
                    'message' => Config::get('constants.ERROR.WRONG_CREDENTIAL'), ];
            }
        } else {
            $data = ['success' => false,
                'message' => Config::get('constants.ERROR.ACCOUNT_ISSUE'), ];
        }

        echo json_encode($data);
    }

    protected function credentials(Request $request)
    {
        return array_merge($request->only($this->username(), 'password'), ['status' => 1, 'verified' => 1]);
    }
}
