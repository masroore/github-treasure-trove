<?php

namespace App\Http\Controllers;

use App\Permission;
use Illuminate\Support\Str;

class PermissionController extends Controller
{
    /**
     * PermissionController constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(Permission::class, 'permissions');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $data = request()->validate([
            'display_name' => 'required | string | min:3 | max:200 | unique:permissions',
            'description' => 'required | string | min:3 | max:200',
        ]) + [
            'slug' => Str::of(request('display_name'))->slug(),
        ];
        $permission = new Permission();
        $permission->display_name = $data['display_name'];
        $permission->slug = $data['slug'];
        $permission->description = $data['description'];
        $permission->save();

        $notification = [
            'message' => 'New Permission Created',
            'alert-type' => 'success',
        ];

        // Return to previews page
        return redirect()->route('roles.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Permission $permission)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        return view('roles.permissions.edit')->withPermission($permission);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Permission $permission)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        echo 'No need to delete permissions';
    }
}
