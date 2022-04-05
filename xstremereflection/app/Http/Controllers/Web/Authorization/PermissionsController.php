<?php

namespace Vanguard\Http\Controllers\Web\Authorization;

use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Requests\Permission\CreatePermissionRequest;
use Vanguard\Http\Requests\Permission\UpdatePermissionRequest;
use Vanguard\Permission;
use Vanguard\Repositories\Permission\PermissionRepository;
use Vanguard\Repositories\Role\RoleRepository;

/**
 * Class PermissionsController.
 */
class PermissionsController extends Controller
{
    /**
     * @var RoleRepository
     */
    private $roles;

    /**
     * @var PermissionRepository
     */
    private $permissions;

    /**
     * PermissionsController constructor.
     */
    public function __construct(RoleRepository $roles, PermissionRepository $permissions)
    {
        $this->roles = $roles;
        $this->permissions = $permissions;
    }

    /**
     * Displays the page with all available permissions.
     *
     * @return Factory|View
     */
    public function index()
    {
        return view('permission.index', [
            'roles' => $this->roles->all(),
            'permissions' => $this->permissions->all(),
        ]);
    }

    /**
     * Displays the form for creating new permission.
     *
     * @return Factory|View
     */
    public function create()
    {
        return view('permission.add-edit', ['edit' => false]);
    }

    /**
     * Store permission to database.
     *
     * @return mixed
     */
    public function store(CreatePermissionRequest $request)
    {
        $this->permissions->create($request->all());

        return redirect()->route('permissions.index')
            ->withSuccess(__('Permission created successfully.'));
    }

    /**
     * Displays the form for editing specific permission.
     *
     * @return Factory|View
     */
    public function edit(Permission $permission)
    {
        return view('permission.add-edit', [
            'edit' => true,
            'permission' => $permission,
        ]);
    }

    /**
     * Update specified permission.
     *
     * @return mixed
     */
    public function update(Permission $permission, UpdatePermissionRequest $request)
    {
        $this->permissions->update($permission->id, $request->all());

        return redirect()->route('permissions.index')
            ->withSuccess(__('Permission updated successfully.'));
    }

    /**
     * Destroy the permission if it is removable.
     *
     * @return mixed
     */
    public function destroy(Permission $permission)
    {
        if (!$permission->removable) {
            throw new NotFoundHttpException();
        }

        $this->permissions->delete($permission->id);

        return redirect()->route('permissions.index')
            ->withSuccess(__('Permission deleted successfully.'));
    }
}
