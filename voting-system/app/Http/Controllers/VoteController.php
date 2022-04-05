<?php

namespace App\Http\Controllers;

use App\Models\Nominations;
use App\Models\Seasons;
use App\Models\Stages;
use App\Models\User;
use App\Models\Votes;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

class VoteController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $user = Socialite::driver('google')->user();

            $finduser = User::where('google_id', $user->id)->first();

            if ($finduser) {
                Auth::login($finduser);

                return redirect()->route('welcome')->with('success', 'Validated Successully! Please vote!');
            }
            $newUser = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'google_id' => $user->id,
                'ipaddress' => $request->ip(),
                'device' => $request->server('HTTP_USER_AGENT'),
                'password' => Hash::make('12345678'),
                'email_verified_at' => date('d-m-y H:i:s'),
            ]);

            Auth::login($newUser);

            return redirect()->route('welcome')->with('success', 'Validated Successully! Please vote!');
        } catch (Exception $e) {
            return redirect()->route('welcome')->with('error', 'Login Failed! Please try again!');
        }
    }

    public function vote(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'userid' => 'required|exists:users,id',
                'group' => 'required|exists:groups,id',
                'artist' => 'required|exists:artists,id',

            ],
            [
                'userid.required' => 'User is required!',
                'userid.exists' => 'User not found!',
                'group.required' => 'Group is reqquired',
                'group.exists' => 'Group not found',
                'artist.exists' => 'Artist not found',
                'artist.required' => 'Artist is required!',

            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'ok' => false,
                'msg' => 'Failed: ' . implode(' ', $validator->errors()->all()),
            ]);
        }

        try {
            $season = Seasons::where('status', 0)->first();
            $stage = Stages::where('status', 0)->first();
            $user = User::find($request->userid);

            $checkNomination = Nominations::where('group_id', $request->group)
                ->where('artist_id', $request->artist)->where('season_id', $season->id)->where('stage_id', $stage->id)->where('status', 0)->first();

            if (!$checkNomination) {
                return response()->json([
                    'ok' => false,
                    'msg' => 'Artist not eligible for voting!',
                ]);
            }

            $checkMultipleVoting = Votes::where('group_id', $request->group)
                ->where('stage_id', $stage->id)
                ->where('email', $user->email)
                ->where('season_id', $season->id)
                ->first();

            if ($checkMultipleVoting) {
                return response()->json([
                    'ok' => false,
                    'msg' => 'You have voted in this group already!',
                ]);
            }

            Votes::create([
                'artist_id' => $request->artist,
                'group_id' => $request->group,
                'email' => $user->email,
                'stage_id' => $stage->id,
                'season_id' => $season->id,
                'ipaddress' => $request->ip(),
                'device' => $request->server('HTTP_USER_AGENT'),
            ]);

            return response()->json([
                'ok' => true,
                'msg' => 'Vote Casted!',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'ok' => false,
                'msg' => 'An error occured while adding voting, please contact admin',
                'error' => [
                    'msg' => $e->__toString(),
                    'fix' => 'Please complete all required fields',
                ],
            ]);
        }
    }
}
