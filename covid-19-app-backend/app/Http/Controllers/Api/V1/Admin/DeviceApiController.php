<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DeviceApiController extends Controller
{
    public function save(Request $request)
    {
        $devise = Device::where('udid', $request->udid)->firstOrNew();
        if (empty($devise->key)) {
            $devise->key = Str::uuid();
        }
        $devise->udid = $request->udid;
        $devise->token = $request->token;
        $devise->save();

        return Device::where('udid', $request->udid)->first();
    }

    public function positif(Request $request)
    {
        $devise = Device::where('udid', $request->udid)->firstOrNew();
        if (empty($devise->key)) {
            $devise->key = Str::uuid();
        }
        $devise->covid = 1;
        $devise->risk = 1;
        $devise->save();

        $SERVER_API_KEY = 'AAAAvO9kHo4:APA91bGbCVzLul_wWug7zPJHi3YIyCVYrbcBQHB04fZoMp3Mh-SZwQceFLgSVW-CFOqSyZQuOs7crQKWHyOQGqFR6Hwj1UmDuMmmyDnxtgeQVhZJJBM4_JdwQ-OctjfeEpm-9D0E4cOt';
        $token_1 = $request->notifToken;

        $data = [
        'registration_ids' => [
            $token_1,
        ],
        'notification' => [

            'title' => 'Notification',

            'body' => 'Description',

            'sound'=> 'default', // required for sound on ios
        ],
    ];

        $dataString = json_encode($data);

        $headers = [

        'Authorization: key=' . $SERVER_API_KEY,

        'Content-Type: application/json',

    ];

        $ch = curl_init();

        curl_setopt($ch, \CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');

        curl_setopt($ch, \CURLOPT_POST, true);

        curl_setopt($ch, \CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, \CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, \CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, \CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);

        dd($response);

        return Device::where('udid', $request->udid)->first();
    }
}
