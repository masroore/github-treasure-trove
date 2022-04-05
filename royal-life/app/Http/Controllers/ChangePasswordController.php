<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    /**
     * llama al middleware auth.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Retorna a la vista.
     */
    public function index()
    {
        return view('users.componenteProfile.changePassword');
    }

    /**
     * Funcion para cambiar la contraseña.
     */
    public function store(Request $request)
    {
        $request->validate([

            'current_password' => ['required', new MatchOldPassword()],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],

        ]);

        User::find(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);

        return redirect('/dashboard/user/profile')->with('msj-success', 'La Contraseña Fue Actualizada Exitosamente');
    }
}
