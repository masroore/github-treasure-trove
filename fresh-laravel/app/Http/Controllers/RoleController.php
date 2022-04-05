<?php

namespace App\Http\Controllers;

use App\DataTables\RolesDataTable;
use App\Models\Module;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    // function __construct()
    // {
    //     $this->middleware('permission:manage-role|create-role|edit-role|delete-role', ['only' => ['index', 'show']]);
    //     $this->middleware('permission:create-role', ['only' => ['create', 'store']]);
    //     $this->middleware('permission:edit-role', ['only' => ['edit', 'update']]);
    //     $this->middleware('permission:delete-role', ['only' => ['destroy']]);
    // }

    public function index(RolesDataTable $dataTable)
    {
        if (Auth::user()->can('manage-role')) {
            return $dataTable->render('roles.index');
        }

        return redirect()->back()->with('error', 'Permission denied.');
    }

    public function create()
    {
        if (Auth::user()->can('create-role')) {
            $permission = Permission::get();

            return view('roles.create', compact('permission'));
        }

        return redirect()->back()->with('error', 'Permission denied.');
    }

    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
        ]);

        $role = Role::create(['name' => $request->input('name')]);

        return redirect()->route('roles.index')
            ->with('message', __('Role Added successfully.'));
    }

    public function show($id)
    {
        if (Auth::user()->can('show-role')) {
            $role = Role::find($id);
            $permissions = $role->permissions->pluck('name', 'id')->toArray();
            $allpermissions = Permission::all()->pluck('name', 'id')->toArray();
            $allmodules = Module::all()->pluck('name', 'id')->toArray();

            return view('roles.show')
                ->with('role', $role)
                ->with('permissions', $permissions)
                ->with('allpermissions', $allpermissions)
                ->with('moduals', $allmodules);
        }

        return redirect()->back()->with('error', 'Permission denied.');
    }

    public function edit($id)
    {
        if (Auth::user()->can('edit-role')) {
            $role = Role::find($id);
            $permission = Permission::get();
            $rolePermissions = DB::table('role_has_permissions')->where('role_has_permissions.role_id', $id)
                ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
                ->all();

            return View('roles.edit', compact('role', 'permission', 'rolePermissions'));
        }

        return redirect()->back()->with('error', 'Permission denied.');
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->can('edit-role')) {
            request()->validate([
                'name' => 'required',
            ]);
            $role = Role::find($id);
            $role->name = $request->input('name');
            $role->save();

            $role->syncPermissions($request->input('permission'));

            return redirect()->route('roles.index')
                ->with('message', __('Role updated successfully'));
        }
    }

    public function destroy($id)
    {
        if (Auth::user()->can('delete-role')) {
            $role = Role::find($id);
            if ($id == 1) {
                return redirect()->back()->with('error', 'Permission denied.');
            }

            $role->delete();

            return redirect()->route('users.index')->with('message', __('Role delete successfully.'));
        }
    }

    public function assignPermission(Request $request, $id)
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        $role = Role::find($id);
        $permissions = $role->permissions()->get();
        $role->revokePermissionTo($permissions);
        $role->givePermissionTo($request->permissions);

        return redirect()->route('roles.index')->with('message', __('Permissions assigned to Role successfully'));
    }
}
