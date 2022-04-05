<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(Request $request): void
    {
        dd('tested');
        // $user = User::all();
        // dd($user);
        /* return view('test', [
            'upso_type_id' => $request->upso_type_id,
            'main_region_id' => $request->main_region_id,
            'region_id' => $request->region_id,
        ]);
 */
    }
}
