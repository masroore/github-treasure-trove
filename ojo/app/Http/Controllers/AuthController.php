<?php

namespace App\Http\Controllers;

use App\Models\User;

use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Browser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use PragmaRX\Google2FA\Google2FA;
use Validator;

class AuthController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect(route('home'));
        }

        return view('auth/login');
    }

    public function logout()
    {

        //Log

        activity()
            ->causedBy(auth::user()->id)
            ->performedOn(new User())
            ->event('Logout')
            ->withProperties([
                'IP' => request()->ip(),
                'browser' => Browser::browserName(),
                'Os' => Browser::platformName(),
            ])
            ->log('Logout of system.');

        Auth::logout();

        setcookie('2FA-TOKEN', '', time() - 3600);

        return redirect('/');
    }

    public function validacion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required|numeric|min:6',
        ]);

        if ($validator->fails()) {
            session()->flash('message', 'Código de 2FA invalido.');

            return redirect()->route('form_validacion');
        }

        $google2fa = new Google2FA();

        $secret = $request->input('secret');

        $window = 1;

        //validacion 2FA

        $valid = $google2fa->verifyKey(Auth::user()->google2fa_secret, $secret, $window);

        if ($valid === true) {

        //CREAR SESSION 2fa PARA VALIDAR
            $cryptoUserID = Crypt::encryptString(auth::user()->id);

            //Log

            activity()
                ->causedBy(auth::user()->id)
                ->performedOn(new User())
                ->event('Login')
                ->withProperties([
                    'IP' => request()->ip(),
                    'browser' => Browser::browserName(),
                    'Os' => Browser::platformName(),
                ])
                ->log('Login to system.');

            setcookie('2FA-TOKEN', $cryptoUserID, time() + 30 * 24 * 60 * 60);

            session()->flash('message', 'Autenticación.');

            return redirect()->route('home');
        }

        setcookie('2FA-TOKEN', '', time() - 3600);

        session()->flash('message', 'Error en código de 2FA.');

        return redirect()->route('form_validacion');
    }

    public function form_validacion()
    {
        if (Auth::check()) {
            return view('google2fa.form_validacion');
        }

        return view('auth/login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'g-recaptcha-response' => 'required|recaptcha',
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            session()->flash('message', 'Error en la validación de datos.');

            return redirect()->route('init');
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->is_active == 0) {
                return redirect()->route('logout');

                session()->flash('message', 'Usuario desactivado, comunicarse con su administrador.');
            }

            //registro de 2FA
            if (Auth::user()->google2fa_enable == 0) {
                $google2fa = new Google2FA();

                $google2fa_secret = $google2fa->generateSecretKey();

                $user = User::find(Auth::user()->id);

                $user->google2fa_enable = 1;

                $user->google2fa_secret = $google2fa_secret;

                $user->save();

                $g2faUrl = $google2fa->getQRCodeUrl(
                    config('app.name'),
                    'WX' . Auth::user()->id . 'RB',
                    $google2fa_secret
                );

                $writer = new Writer(
                    new ImageRenderer(
                        new RendererStyle(400),
                        new ImagickImageBackEnd()
                    )
                );

                $qrcode_image = base64_encode($writer->writeString($g2faUrl));

                return view('google2fa.register', ['QR_Image' => $qrcode_image, 'secret' => $google2fa_secret]);
            }

            // AUTENTICACION 2FA

            return redirect()->route('form_validacion');

            session()->flash('message', 'Ingreso correcto.');
        } else {
            session()->flash('message', 'Existe un error con tus datos.');

            return redirect()->route('init');
        }
    }
}
