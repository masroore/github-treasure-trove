<?php

namespace App\Http\Controllers;

use App\Models\User;
use BaconQrCode\Renderer\Image\Png;
use BaconQrCode\Writer as BaconQrCodeWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Google2FA;

class DoubleAutenticationController extends Controller
{
    /**
     * Undocumented function.
     */
    public function index()
    {
        $urlQr = $this->verificar2fact(Auth::id());

        return view('auth.fact2', compact('urlQr'));
    }

    /**
     * Permite verificar si un usuario ya tiene su 2Fact.
     *
     * @param int $iduser
     */
    public function verificar2fact($iduser): string
    {
        $check2Fact = User::where([
            ['id', '=', $iduser],
            ['token_google', '!=', ''],
            ['activar_2fact', '=', 1],
        ])->first();
        $result = '';
        if ($check2Fact == null) {
            User::where('id', '=', $iduser)->update([
                'token_google' => (new Google2FA())->generateSecretKey(),
            ]);
            $user = User::find($iduser);
            $result = $this->createUserUrlQR($user);
        }

        return $result;
    }

    /**
     * Permite general el codigo QR para el codigo.
     *
     * @param object $user
     */
    public function createUserUrlQR($user)
    {
        $renderer = new Png();
        $renderer->setWidth(200);
        $renderer->setHeight(200);
        $bacon = new BaconQrCodeWriter($renderer);

        $data = $bacon->writeString(
            (new Google2FA())->getQRCodeUrl(
                config('app.name'),
                $user->email,
                $user->token_google
            ),
            'utf-8'
        );

        return 'data:image/png;base64,' . base64_encode($data);
    }

    /**
     * Permite verificar 2fact del login.
     */
    public function checkCodeLogin(Request $request)
    {
        $validate = $request->validate([
            'code' => 'required|numeric',
        ]);
        if ($validate) {
            if ($this->checkCode(Auth::id(), $request->code)) {
                $user = User::find(Auth::id());
                if ($user->activar_2fact == 0) {
                    $user->activar_2fact = 1;
                    $user->save();
                }
                session(['2fact' => 1]);

                return redirect()->route('home');
            }

            return redirect()->back()->withErrors(['error' => 'Código de verificación incorrecto']);
        }
    }

    /**
     * Permite verificar si el codigo Es correcto.
     *
     * @param int $iduser
     * @param int $code
     */
    public function checkCode($iduser, $code): bool
    {
        $user = User::find($iduser);
        $result = false;
        if ((new Google2FA())->verifyKey($user->token_google, $code)) {
            $result = true;
        }

        return $result;
    }
}
