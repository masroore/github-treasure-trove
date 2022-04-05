<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RecapchaController extends Controller
{
    public function index(Request $request)
    {
        return view('recapcha.recapcha');
    }

    public function show(Request $request)
    {
        return view('recapcha.recapcha-inside', [
            'redirect' => false,
        ]);
    }

    public function store(Request $request): void
    {
        /*  $secret = env( 'RECAPCHA_SECRET_KEY');
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret );

        $data = [
            'secret'=>$secret,
            'response'=> $_POST['token'],
            'remote_ip'=> $request->ip(),
        ];
        $options = [
            'http'=> [
                'header'=>"Content-type: application/x-www-form-urlencoded\r\n",
                'method'=>'POST',
                'content'=> http_build_query($data)
            ]
        ];
        $context = stream_context_create($options);
        $response = json_decode(file_get_contents( $url, false, $context), true);

        if( (float) $response['score'] <= 0.5 ) {
            $redirect = true;
        } else{
            $redirect = false;
        }

        return view('recapcha.recapcha', [
            'redirect'=> $redirect,
        ]); */
    }

    public function ajax(Request $request)
    {

        // RECAPCHA_SITE_KEY=6Le4ljcaAAAAAPvQQ7WMcJvtJUzKb3pUlkOM6d5F
        // RECAPCHA_SECRET_KEY=6Le4ljcaAAAAAKAtJP230x_DnYX-E0GEfd4qHXX_

        $token = json_decode($request->json, true)['token'];

        $secret = '6Le4ljcaAAAAAKAtJP230x_DnYX-E0GEfd4qHXX_';
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret);

        $data = [
            'secret' => $secret,
            'response' => $token,
            // 'remote_ip'=> $request->ip(),
        ];
        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data),
            ],
        ];
        $context = stream_context_create($options);
        $response = json_decode(file_get_contents($url, false, $context), true);

        // Log::info($response);

        if ($response['success'] == false) {
            $data = [
                'now' => Carbon::now()->toDateTimeString(),
                'success' => false,
                'response' => $response,
            ];
        } else {
            $data = [
                'now' => Carbon::now()->toDateTimeString(),
                'success' => $response['success'] == true ? '1' : '0',
                'score' => $response['score'],
                // 'response'=> $response,
            ];
        }

        return $data;
    }
}
