<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string',
        ], [
            'email.required' => 'Email обязателен для заполнения',
            'email.email' => 'Необходимо ввести валидный Email адрес',
            'password.required' => 'Пароль обязателен для заполнения',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'token' => '',
                'errors' => [
                    'email' => count($validator->errors()->get('email')) == 0 ? '' : $validator->errors()->get('email')[0],
                    'password' => count($validator->errors()->get('password')) == 0 ? '' : $validator->errors()->get('password')[0],
                ],
            ]);
        }
        if (User::where('email', $request->get('email'))->count() == 0) {
            return response()->json([
                'status' => false,
                'token' => '',
                'errors' => [
                    'email' => 'Пользователь не найден',
                    'password' => '',
                ],
            ]);
        }
        $user = User::where('email', $request->get('email'))->first();

        if (Hash::check($request->get('password'), $user->password)) {
            if ($user->deleted || $user->dismissed) {
                return response()->json([
                    'status' => false,
                    'token' => '',
                    'errors' => [
                        'email' => 'Учетная запись заблокирована',
                        'password' => '',
                    ],
                ]);
            }
        }

        if (Hash::check($request->get('password'), $user->password)) {
            $token = Str::random(60);
            $user->api_token = hash('sha256', $token);
            $user->save();

            return response()->json([
                'status' => true,
                'token' => $token,
                'errors' => [
                    'email' => '',
                    'password' => '',
                ],
            ]);
        }

        return response()->json([
            'status' => false,
            'token' => '',
            'errors' => [
                'email' => 'Нвеверный пароль',
                'password' => '',
            ],
        ]);
    }
}
