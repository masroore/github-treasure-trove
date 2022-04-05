<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function pass(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = $request->input('password');
        $hashed_password = bcrypt($validator);

        return response()->json([
            'hash' => $hashed_password,
        ]);
    }
}
