<?php

namespace App\Http\Controllers;

use App\DataTables\UserDatatable;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of tags.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserDatatable $userDatatable)
    {
        return $userDatatable->render('panel.users.index');
    }

    public function viewProfile($id)
    {
        $user = User::find($id);

        $calendar = null;
        $hospital = null;

        if (empty($user)) {
            abort(404, 'No se encontro el usuario');
        }

        return view('panel.users.profile')
            ->with([
                'user' => $user,
                'hospital' => $hospital,
                'calendar' => $calendar,
            ]);
    }
}
