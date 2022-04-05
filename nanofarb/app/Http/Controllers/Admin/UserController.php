<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\Shop\Order;
use App\Models\User;
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
        $this->authorize('user.read');

        $users = User::orderBy('id', 'desc')
            ->with('roles')->paginate();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $this->authorize('user.create');

        $password = $request->password;
        $request->merge(['password' => bcrypt($password)]);
        $attributes = $request->only('name', 'last_name', 'email', 'active', 'phone', 'password');

        $user = User::create($attributes);
        $user->assignRole($request->roles);

        event(new \App\Events\User\Created($user, $password));

        $destination = $request->session()->pull('destination', route('admin.users.edit', $user));

        return redirect()->to($destination)
            ->with('success', trans('notifications.store.success'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $this->authorize('user.update');

        $attributes = $request->only('name', 'last_name', 'email', 'active', 'phone');
        $user = User::findOrFail($id);

        if ($request->password) {
            $user->setAttribute('password', bcrypt($request->password));
            $user->setAttribute('data->password', '');
            $user->save();
        }

        $user->update($attributes);
        $user->syncRoles($request->roles);

        $destination = $request->session()->pull('destination', route('admin.users.edit', $user));

        return redirect()->to($destination)
            ->with('success', trans('notifications.update.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $this->authorize('user.delete');

        $user = User::findOrFail($id);

        $destination = $request->session()->pull('destination', route('admin.users.index'));
        if ($user->orders->where('type', Order::TYPE_ORDER)->count()) {
            return redirect()->to($destination)
                ->with('error', 'Ошибка удаления! Для удаления пользователя сначала удалите его заказы.');
        }

        $user->delete();

        return redirect()->to($destination)
            ->with('success', trans('notifications.destroy.success'));
    }
}
