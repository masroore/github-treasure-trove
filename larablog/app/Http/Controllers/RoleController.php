<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        // Check RolePolicy if the user has permission to perform this task
        $this->authorize('viewAny', Role::class);

        return view('roles.index', [
            'roles' => Role::all(),
            'permissions' => Permission::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return RedirectResponse
     */
    public function store()
    {
        // Check RolePolicy if the user has permission to perform this task
        $this->authorize('create', Role::class);

        $role = Role::create(request()->validate([
            'name' => 'required | string | min:3 | max:10',
        ]));

        $role->permissions()->sync(request()->permissions, false);

        $notification = [
            'message' => 'New Role Created',
            'alert-type' => 'success',
        ];

        // Return to previews page
        return redirect()->route('roles.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @return Application|Factory|View
     */
    public function show(Role $role)
    {
        // Check RolePolicy if the user has permission to perform this task
        $this->authorize('view', Role::class);

        return view('roles.show', ['permissions' => Permission::all()])->withRole($role);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Application|Factory|View
     */
    public function edit(Role $role)
    {
        // Check RolePolicy if the user has permission to perform this task
        $this->authorize('update', Role::class);

        $permissions = Permission::all();

        return view('roles.edit')->withRole($role)->withPermissions($permissions);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return RedirectResponse
     */
    public function update(Role $role)
    {
        // Check RolePolicy if the user has permission to perform this task
        $this->authorize('update', Role::class);

        request()->validate([
            'name' => 'required | string | max:10',
        ]);

        // Check if permissions has changed or not
        if (isset(request()->permissions)) {
            $role->permissions()->sync(request()->permissions);
        } else {
            $role->permissions()->sync([]);
        }

        $notification = [
            'message' => 'Your changes is saved',
            'alert-type' => 'success',
        ];

        // Return to previews page
        return redirect()->route('roles.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return RedirectResponse
     */
    public function destroy(Role $role)
    {
        // Check RolePolicy if the user has permission to perform this task
        $this->authorize('delete', Role::class);

        $role->permissions()->detach();

        $role->delete();

        $notification = [
            'message' => 'Role deleted',
            'alert-type' => 'success',
        ];

        // Return to previews page
        return redirect()->route('roles.index')->with($notification);
    }
}
