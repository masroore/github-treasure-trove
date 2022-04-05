<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Validation\ValidationException;

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
    protected $redirectTo = '/';

    /**
     * Default field in DB for login.
     *
     * @var string
     */
    protected $fieldLogin = 'email';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('front.auth.login');
    }

    protected function validateLogin(Request $request): void
    {
        $this->validate($request, [
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $this->fieldLogin = filter_var($request->get('login'), FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'phone';
    }

    /**
     * @return array
     */
    protected function credentials(Request $request)
    {
        return [
            $this->fieldLogin => $request->get('login'),
            'password' => $request->get('password'),
            'active' => true,
        ];
    }

    protected function sendFailedLoginResponse(Request $request): void
    {
        throw ValidationException::withMessages([
            'login' => [trans('auth.failed')],
        ]);
    }

    protected function authenticated(Request $request, $user)
    {
        $this->redirectTo = $request->session()->pull('destination') ?? route_alias('start');
        $path = $request->session()->pull('url.intended', $this->redirectTo);
        $cookie = Cookie::forget('uuid');
        if ($request->ajax()) {
            return response()->json([
                'message' => trans('notifications.operation.success'),
                'action' => 'redirect',
                'destination' => $path,
                //'destination' => $this->redirectTo,
            ])->withCookie($cookie);
        }
    }

    protected function loggedOut(Request $request)
    {
        //$this->redirectTo = $request->session()->pull('destination') ?? '/';

        if ($request->ajax()) {
            return response()->json([
                'message' => trans('notifications.operation.success'),
                'action' => 'redirect',
                //                'destination' => $this->redirectTo,
                'destination' => url($request->get('locale', '/')),
            ]);
        }
    }
}
