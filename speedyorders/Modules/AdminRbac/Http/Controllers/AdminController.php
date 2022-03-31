<?php

namespace Modules\AdminRbac\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\AdminRbac\Http\Requests\CreateUserRequest;
use Modules\AdminRbac\Http\Requests\UpdatePasswordRequest;
use Modules\AdminRbac\Http\Requests\UpdateUserRequest;
use Modules\AdminRbac\Models\AdminGroup;
use Modules\AdminRbac\Models\AdminUserGroup;
use Modules\AdminRbac\Services\CreateUserService;
use Modules\AdminRbac\Services\UpdateUserService;
use Modules\AdminRbac\Utils\RbacHelper;

class AdminController extends Controller
{
    /**
     * @return Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data['users'] = User::with('userGroup')->orderByDesc('id')->paginate(50);

        $data['menu'] = 'users';

        $data['sub_menu'] = 'view-users';

        return view('adminrbac::users.index', $data);
    }

    /**
     * @return Factory|\Illuminate\View\View
     */
    public function create()
    {
        $data['menu'] = 'users';

        $data['sub_menu'] = 'create-users';

        $data['groups'] = AdminGroup::where('id', '!=', RbacHelper::SUPER_ADMIN_ROLE)
            ->where('status', RbacHelper::ACTIVE)
            ->get();

        return view('adminrbac::users.create', $data);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateUserRequest $request, CreateUserService $service)
    {
        $data = $request->validated();

        if ($service->handle($data)) {
            session()->flash('success_message', 'User created successfully.');
        } else {
            session()->flash('error_message', 'New user could not be added.');
        }

        return redirect()->route('users');
    }

    /**
     * @param $id
     *
     * @return Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $data['menu'] = 'users';

        $data['sub_menu'] = 'edit-users';

        $data['user'] = User::findOrFail($id);

        $data['groups'] = AdminGroup::where('id', '!=', RbacHelper::SUPER_ADMIN_ROLE)
            ->where('status', RbacHelper::ACTIVE)
            ->get();

        $data['current_groups'] = AdminUserGroup::where('user_id', $data['user']->id)
            ->pluck('group_id')
            ->toArray();

        return view('adminrbac::users.edit', $data);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateUserRequest $request, $id, UpdateUserService $service)
    {
        $data = $request->validated();

        if ($service->handle($data, $id)) {
            session()->flash('success_message', 'User updated successfully.');
        } else {
            session()->flash('error_message', 'User could not be updated.');
        }

        return redirect()->route('users');
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $user = User::find($id);

        try {
            $user->delete();

            session()->flash('success_message', 'User deleted successfully.');

            return redirect()->route('users');
        } catch (\Exception $e) {
            session()->flash('failure_message', 'User could not be deleted.');

            return back();
        }
    }

    public function changeStatus($id, UpdateUserService $service)
    {
        $user = User::find($id);

        if ($user) {
            if (1 == $user->status) {
                $user->update(['status' => 0]);
            } else {
                $user->update(['status' => 1]);
            }
        }

        session()->flash('success_message', 'User updated successfully.');

        return redirect()->back();
    }

    public function updatePassword(
        $id,
        UpdatePasswordRequest $request,
        UpdateUserService $service
    ) {
        $data = [
            'password' => bcrypt($request->get('new_password')),
        ];

        if ($service->handle($data, $id)) {
            session()->flash('success_message', 'Password updated successfully.');
        } else {
            session()->flash('error_message', 'Password could not be updated.');
        }

        return back();
    }

    public function profile()
    {
        try {
            $data['user'] = auth('admin')->user();

            return view('adminrbac::users.profile', $data);
        } catch (Exception $ex) {
            echo $ex->getMessage();
            exit;
        }
    }

    public function updateProfile(Request $request)
    {
        try {
            $user = auth('admin')->user();

            $request->validate([
                'email' => 'required|email|unique:admin_users,email,' . $user->id,
                'first_name' => 'required',
                'last_name' => 'required',
                'username' => 'required|alpha_dash|unique:admin_users,username,' . $user->id,
            ]);

            $data = $request->only('first_name', 'last_name', 'contact', 'username', 'email');

            User::find($user->id)->update($data);

            session()->flash('success_message', 'Profile updated successfully.');
        } catch (\Exception $e) {
            session()->flash('error_message', 'Profile could not be updated.');
        }

        return redirect()->back();
    }

    public function resetPassword()
    {
        return view('adminrbac::change-password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_password' => 'same:new_password',
        ]);

        $user = auth()->guard('admin')->user();

        if (Hash::check($request->current_password, $user->password)) {
            if (Hash::check($request->new_password, $user->password)) {
                session()->flash('error_message', 'New password and old password are same.');

                return redirect()->back();
            }

            User::find($user->id)
                ->update([
                'password' => bcrypt($request->new_password),
            ]);

            session()->flash('success_message', 'Password reset successfully, please re-login.');

            auth()->guard('admin')->logout();

            return redirect()->route('admin.login');
        }

        session()->flash('error_message', 'New password and old password are same.');

        return redirect()->back();
    }
}
