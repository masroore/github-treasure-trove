<?php

namespace App\Http\Controllers;

class ApiController extends Controller
{
    public function getDolarApi()
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://s3.amazonaws.com/dolartoday/data.json',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        $response = utf8_encode($response);
        $response = json_decode($response);

        $response_result[0]['indicator'] = 'TASA BCV';
        $response_result[0]['value'] = $response->USD->promedio_real;
        $response_result[0]['description'] = '';

        return response()->json($response_result);
    }
}
