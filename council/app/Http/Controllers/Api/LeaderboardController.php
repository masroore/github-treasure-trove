<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;

class LeaderboardController extends Controller
{
    public function index()
    {
        return [
            'leaderboard' => User::limit(10)->orderBy('reputation', 'desc')->get(),
        ];
    }
}
