<?php

namespace Modules\AdminRbac\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\AdminRbac\Http\Requests\GroupRequest;
use Modules\AdminRbac\Models\AdminGroup;
use Modules\AdminRbac\Models\AdminPermissionGroup;
use Modules\AdminRbac\Models\AdminPermissionModule;
use Modules\AdminRbac\Services\CreateGroupService;
use Modules\AdminRbac\Services\UpdateGroupService;
use Modules\AdminRbac\Services\UpdatePermissionService;

class GroupController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data['groups'] = AdminGroup::orderByDesc('id')->get();

        $data['menu'] = 'users';

        return view('adminrbac::groups.index', $data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $data['menu'] = 'users';

        return view('adminrbac::groups.create', $data);
    }

    public function store(GroupRequest $request, CreateGroupService $service)
    {
        $data = $request->validated();

        if ($service->handle($data)) {
            session()->flash('success_message', 'Group created successfully.');
        } else {
            session()->flash('error_message', 'Group created successfully.');
        }

        return redirect()->route('groups');
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        return view('adminrbac::show');
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit($id)
    {
        $data['group'] = AdminGroup::find($id);

        $data['menu'] = 'users';

        if (!$data['group']) {
            session()->flash('error_message', 'Group does not exist.');

            return redirect()->route('groups');
        }

        return view('adminrbac::groups.edit', $data);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(
        GroupRequest $request,
        $id,
        UpdateGroupService $service
    ) {
        $data = $request->validated();

        if ($service->handle($data, $id)) {
            session()->flash('success_message', 'Group updated successfully.');
        } else {
            session()->flash('error_message', 'Group could not be updated.');
        }

        return redirect()->route('groups');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function delete($id)
    {
        $group = AdminGroup::find($id);

        try {
            $group->delete();

            session()->flash('success_message', 'Group deleted successfully.');

            return back();
        } catch (\Exception $e) {
            session()->flash('error_message', 'Group could not be deleted.');

            return back();
        }
    }

    public function editPermission($id)
    {
        $group = AdminGroup::find($id);

        if (!$group) {
            session()->flash('error_message', 'Group does not exist / Group Permission cannot be modified.');

            return redirect()->route('groups');
        }

        $data['menu'] = 'users';

        $data['group'] = $group;

        $data['modules'] = AdminPermissionModule::with('permissionReferences')
            ->get();

        $data['group_permission'] = AdminPermissionGroup::where('group_id', $id)
            ->pluck('permission_reference_id')
            ->toArray();

        return view('adminrbac::groups.permission', $data);
    }

    public function storePermission(
        $id,
        Request $request,
        UpdatePermissionService $service
    ) {
        $data = $request->only('permission_reference_id');

        if ($service->handle($data, $id)) {
            session()->flash('success_message', 'Group\'s Permissions updated successfully.');
        } else {
            session()->flash('error_message', 'Group\'s Permissions could not be updated.');
        }

        return redirect()->route('groups.edit-permission', $id);
    }
}
