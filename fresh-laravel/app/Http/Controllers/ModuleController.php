<?php

namespace App\Http\Controllers;

use App\DataTables\ModulesDataTable;
use App\Models\Module;
use Auth;
use DB;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class ModuleController extends Controller
{
    public function index(ModulesDataTable $table)
    {
        if (Auth::user()->can('manage-module')) {
            return $table->render('modules.index');
        }

        return redirect()->back()->with('error', 'Permission denied.');
    }

    public function create()
    {
        if (Auth::user()->can('create-module')) {
            $module = Module::get();

            return view('modules.create', compact('module'));
        }

        return redirect()->back()->with('error', 'Permission denied.');
    }

    public function store(Request $request)
    {
        if (Auth::user()->can('create-module')) {
            $module = new module();
            $module->name = $request->name;
            $module->save();
            $data = [];
            if (!empty($request['permissions'])) {
                foreach ($request['permissions'] as $check) {
                    if ($check == 'M') {
                        $data[] = ['name' => 'manage-' . $request->name];
                    } elseif ($check == 'C') {
                        $data[] = ['name' => 'create-' . $request->name];
                    } elseif ($check == 'E') {
                        $data[] = ['name' => 'edit-' . $request->name];
                    } elseif ($check == 'D') {
                        $data[] = ['name' => 'delete-' . $request->name];
                    } elseif ($check == 'S') {
                        $data[] = ['name' => 'show-' . $request->name];
                    }
                }
            }
            Permission::insert($data);

            return redirect()->route('modules.index')
                ->with('message', __('module updated successfully'));
        }

        return redirect()->back()->with('error', 'Permission denied.');
    }

    public function show(module $module): void
    {
    }

    public function edit($id)
    {
        if (Auth::user()->can('edit-module')) {
            $module = Module::find($id);

            return view('modules.edit', compact('module'));
        }

        return redirect()->back()->with('error', 'Permission denied.');
    }

    public function update(Request $request, $id)
    {
        $modules = Module::find($id);
        $this->validate($request, [
            'name' => 'required|regex:/^[a-zA-Z0-9\-_\.]+$/|min:4|unique:modules,name,' . $modules->id,
        ], [
            'regex' => 'Invalid Entry! Only letters,underscores,hypens and numbers are allowed',
        ]);
        $modules->name = str_replace(' ', '-', strtolower($request->name));
        $permissions = DB::table('permissions')
            ->where('name', 'like', '%' . $request->old_name . '%')
            ->get();
        // dd($request);
        $module_name = str_replace(' ', '-', strtolower($request->name));

        foreach ($permissions as $permission) {
            $update_permission = Permission::find($permission->id);
            if ($permission->name == 'manage-' . $request->old_name) {
                $update_permission->name = 'manage-' . $module_name;
            }
            if ($permission->name == 'create-' . $request->old_name) {
                $update_permission->name = 'create-' . $module_name;
            }
            if ($permission->name == 'edit-' . $request->old_name) {
                $update_permission->name = 'edit-' . $module_name;
            }
            if ($permission->name == 'delete-' . $request->old_name) {
                $update_permission->name = 'delete-' . $module_name;
            }
            if ($permission->name == 'show-' . $request->old_name) {
                $update_permission->name = 'show-' . $module_name;
            }
            $update_permission->save();
        }
        $modules->save();

        return redirect()->route('modules.index')->with('message', 'Module Updated Sucessfully.');
    }

    public function destroy($id)
    {
        if (Auth::user()->can('delete-module')) {
            Module::where('id', $id)->firstorfail()->delete();

            return redirect()->route('modules.index')->with('message', __('module change successfully.'));
        }

        return redirect()->back()->with('error', 'Permission denied.');
    }
}
