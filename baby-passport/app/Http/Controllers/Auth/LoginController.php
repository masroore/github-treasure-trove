<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SEOMeta;

class LoginController extends Controller
{
    use AuthenticatesUsers;

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

    use SEOToolsTrait;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/mama/proceso';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        $this->seo()->setTitle('BabyPassport | Iniciar sesión');
        $this->seo()->setDescription('Continúa con el proceso para obtener la green card para tu bebé.');

        $this->seo()->opengraph()->setTitle('Iniciar sesión');
        $this->seo()->opengraph()->setUrl(route('web.getPolicies'));
        $this->seo()->opengraph()->addImage(asset('img/logos/slider1_lg_up.jpg'));
        SEOMeta::setKeywords(['turismo maternidad', 'parto en Estados Unidos', 'parto en USA', 'embarazo', 'ginecologos en USA']);

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt([
            'email' => $request['email'],
            'password' => $request['password'],
            'status' => ['active', 'active_suscription'],
        ])) {
            $userType = Auth::user()->type;

            switch ($userType) {
                case 'pacient':
                    return redirect()->route('web.getMomProfile', [Auth::user()->id]);

                    break;
                case 'main-doctor':
                    return redirect()->route('web.getDoctorProfile');

                    break;
                default:
                    return redirect()->route('users.index');
            }
        }

        $request->session()->flash('error', 'Usuario y/o contraseña incorrectos');

        return back();
    }
}
