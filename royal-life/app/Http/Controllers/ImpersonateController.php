<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ImpersonateController extends Controller
{
    /**
     * Permite al administrador entrar a la cuenta que seleciono.
     */
    public function start(User $user)
    {
        session()->put('impersonated_by', auth()->id());

        Auth::login($user);

        return redirect()->route('home')->with('msj-success', 'Has iniciado seccion en otra cuenta');
    }

    /**
     * Permite devolver al administrador a su cuenta original.
     */
    public function stop()
    {
        Auth::loginUsingId(session()->pull('impersonated_by'));

        return redirect()->route('home')
            ->with('msj-success', 'Has iniciado seccion con tu cuenta admin');
    }
}
