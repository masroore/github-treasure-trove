<?php

namespace App\Http\Controllers\Back\Users;

use App\Http\Controllers\Controller;
use App\User;
use Bouncer;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('details')->orderBy('name')->paginate(20);

        return view('back.users.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.users.user.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User();
        $stored = $user->validateRequest($request)->storeData();

        if ($stored) {
            if ($request->has('user_image') && $request->input('user_image')) {
                $user->resolveAvatar($stored->user_id);
            }

            return redirect()->route('users')->with(['success' => 'Korisnik je uspješno snimljen.!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! Došlo je do greške sa snimanjem korisnika...']);
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
        $user = User::where('id', $id)->with('details')->first();

        return view('back.users.user.show', compact('user'));
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
        $user = User::where('id', $id)->with('details')->first();

        return view('back.users.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $old_user = User::where('id', $user->id)->first();
        $updated = $user->validateRequest($request)->updateData($user->id);

        if ($request->has('user_role') && !empty($request->user_role)) {
            Bouncer::retract($old_user->role)->from($user);
            Bouncer::assign($request->user_role)->to($user);
        }

        if ($updated) {
            if ($request->has('user_image') && $request->input('user_image')) {
                $user->resolveAvatar($updated->user_id);
            }

            return redirect()->route('users')->with(['success' => 'Korisnik je uspješno snimljen.!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! Došlo je do greške sa snimanjem korisnika...']);
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
}
