<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function edit(Request $request)
    {
        $this->authorize('account.read');

        return view('admin.account.edit', [
            'user' => $request->user('web'),
        ]);
    }

    public function update(Request $request)
    {
        $this->authorize('account.update');

        $this->validateAccount($request);

        $user = $request->user('web');

        $user->update($this->prepareData($request));

        return redirect()->route('admin.account.edit')
            ->with('success', trans('notifications.update.success'));
    }

    protected function validateAccount(Request $request): void
    {
        $user = $request->user('web');

        $this->validate($request, [
            'name' => 'required|string|min:2',
            'last_name' => 'nullable|string|min:2',
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'password' => 'nullable|string|min:6|confirmed',
        ]);
    }

    public function prepareData(Request $request): array
    {
        $data = [
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
        ];

        if ($request->get('password')) {
            $data['password'] = bcrypt($request->password);
        }

        return $data;
    }
}
