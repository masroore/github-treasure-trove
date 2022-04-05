<?php

namespace App\Traits;

trait SendResponseTrait
{
    public function apiResponse($apiResponse, $statusCode = '404', $message = 'No records Found', $data = [])
    {
        $responseArray = [];
        if ($apiResponse == 'success') {
            $responseArray['api_response'] = $apiResponse;
            $responseArray['status_code'] = $statusCode;
            $responseArray['message'] = $message;
            $responseArray['data'] = $data;
        } else {
            $responseArray['api_response'] = 'error';
            $responseArray['status_code'] = $statusCode;
            $responseArray['message'] = $message;
            $responseArray['data'] = [];
        }

        return response()->json($responseArray);
    }

    public function generateOtp()
    {
        $otp = mt_rand(1000, 9999);

        return $otp;
    }

    public function sendOtp($phone, $otp): void
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'http://api.greenweb.com.bd/api.php?token=a3b50fff7d7c6cd752d8140f5badfdb3&to=' . $phone . '&message=PorashonaOnline: Your code is ' . $otp . ' App ID: FA+9qCX9VSu
        ',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'cache-control: no-cache',
                'postman-token: ef19c99c-228c-67e7-a709-41dd60f25bd5',
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo 'cURL Error #:' . $err;
        } else {
            echo $response;
        }
    }
}
