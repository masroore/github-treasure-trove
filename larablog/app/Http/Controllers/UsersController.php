<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use function request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        // Check UserPolicy if the user has permission to perform this task
        $this->authorize('viewAny', User::class);

        // return to page with posts & pagination
        $users = User::withCount(['posts'])->paginate(10);

        return view('users.index', compact('users'));
    }

    /**
     * Display the specified resource.
     *
     * @return Application|Factory|View
     */
    public function show(User $user)
    {
        // Check UserPolicy if the user has permission to perform this task
        $this->authorize('view', $user);
        $roles = Role::all();

        return view('users.show')->withRoles($roles)->withUser($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Factory|View
     */
    public function edit(User $user)
    {
        // Check UserPolicy if the user has permission to perform this task
        $this->authorize('update', $user);

        return view('users.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Redirector|RedirectResponse
     */
    public function update(User $user)
    {
        // Check UserPolicy if the user has permission to perform this task
        $this->authorize('update', $user);

        // Check if user input password is valid or not
        if (Hash::check(request()->password, $user->password)) {
            $user->update(request()->validate([
                'name' => 'required',
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            ]));

            $notification = [
                'message' => 'Changes saved',
                'alert-type' => 'success',
            ];

            return redirect()->route('users.index')->with($notification);
        }
        // If not valid return with error
        $notification = [
            'message' => 'Password does not match from database',
            'alert-type' => 'error',
        ];

        return back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return RedirectResponse
     */
    public function destroy(User $user)
    {
        // Check UserPolicy if the user has permission to perform this task
        $this->authorize('delete', $user);

        // Check if user is admin or himself
        if (auth()->user()->isAdmin() || auth()->user()->isSuperAdmin()) {
            $user->delete();
            $notification = [
                'message' => 'Admin has deleted user successfully',
                'alert-type' => 'success',
            ];
        } elseif (Auth::id() === $user->id) {
            $user->delete();
            $notification = [
                'message' => 'Your account deleted successfully',
                'alert-type' => 'success',
            ];
        } else {
            $notification = [
                'message' => 'You cannot delete account that you don\'t own',
                'alert-type' => 'error',
            ];
        }

        return back()->with($notification);
    }

    public function showSettings()
    {
        return view('settings.password');
    }

    /**
     * @return RedirectResponse
     */
    public function passChange(User $user)
    {
        // Check if user has inputted current password
        if (request()->current_password == request()->password) {
            $notification = [
                'message' => 'New password can not be your old password',
                'alert-type' => 'error',
            ];
        }
        // Check if user inputted password is valid or not
        if (Hash::check(request()->current_password, $user->password)) {
            $user->update(request()->validate([
                'password' => 'required|confirmed|min:6',
            ]));
            $notification = [
                'message' => 'Password Changed',
                'alert-type' => 'success',
            ];
        }

        return back()->with($notification);
    }

    public function changeRole(User $user)
    {
        // Check UserPolicy if the user has permission to perform this task
        $this->authorize('changeRole', User::class);

        // Change role_id field in users table
        $user->update([
            'role_id' => request('role'),
        ]);

        return response()->json(['success' => 'Role changed successfully']); // return notification on ajax success
    }
}
