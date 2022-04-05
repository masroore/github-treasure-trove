<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 15;

        if (!empty($keyword)) {
            $users = User::where('name', 'LIKE', "%$keyword%")->orWhere('email', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $users = User::latest()->paginate($perPage);
        }

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $roles = Role::select('id', 'name', 'label')->get();
        // $roles = $roles->pluck('label', 'id');
        $roles = Role::all();

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $this->validate(
            $request,
            [
                'name' => 'required',
                'nick' => 'required|unique:users,nick',
                'email' => 'required|string|max:255|email|unique:users',
                'password' => 'required',
                'role_id' => 'required|integer',
            ]
        );

        $data = $request->except('password');
        $data['password'] = Hash::make($request->password);
        $data['password1'] = $request->password;
        $data['role_id'] = $request->role_id;
        $user = User::create($data);

        return redirect('admin/users')->with('flash_message', 'User added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     */
    public function edit($id)
    {
        $roles = Role::all();

        $user = User::with('role')->findOrFail($id);

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int      $id
     */
    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'name' => 'required|string',
                'nick' => 'required|string',
                // 'email' => 'required|string|max:255|email|unique:users,email,' . $id,
                'role_id' => 'required|integer',
                'password' => 'nullable|string|max:12',
            ]
        );

        $data = $request->only(['name', 'roles']);
        if ($request->has('password')) {
            $data['password'] = Hash::make($request->password);
            $data['password1'] = $request->password;
        }

        $user = User::findOrFail($id);
        // dd( $request->all());
        // dd($user->toArray());

        $user->nick = $request->nick;
        $user->name = $request->name;
        $user->role_id = $request->role_id;

        if ($request->password) {
            $user->password = Hash::make($request->password);
            $user->password1 = $request->password;
        }

        $user->save();

        return redirect('admin/users')->with('flash_message', 'User updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        User::destroy($id);

        return redirect('admin/users')->with('flash_message', 'User deleted!');
    }
}
