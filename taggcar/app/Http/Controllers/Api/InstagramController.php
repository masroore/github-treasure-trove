<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Validator;

class InstagramController extends Controller
{
    public function getProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->first();

            return json_encode(['status' => 0, 'message' => $message]);
        }

        $code = $request->code;

        $response = Http::asForm()->post('https://api.instagram.com/oauth/access_token', [
            'client_id' => getenv('INSTAGRAM_CLIENT_ID'),
            'client_secret' => getenv('INSTAGRAM_CLIENT_SECRET'),
            'code' => $code,
            'grant_type' => 'authorization_code',
            'redirect_uri' => 'https://socialsizzle.heroku.com/auth/',
        ]);

        $json = json_decode($response->body());

        if ($response->failed()) {
            return json_encode(['status' => 0, 'message' => $json->error_message]);
        }

        $token = $json->access_token;

        if (empty($token)) {
            return json_encode(['status' => 0, 'message' => "Can't get access token"]);
        }

        $response = $client->request('GET', 'https://graph.instagram.com/me?fields=id,username&access_token=' . $token);

        if ($response->id) {
            return json_encode(['status' => 1, 'data' => ['id' => $response->id, 'username' => $response->username]]);
        }

        return json_encode(['status' => 0, 'message' => "Can't get profile"]);
    }
}
