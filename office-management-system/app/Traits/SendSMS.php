<?php

namespace App\Traits;

use Exception;
use Modules\Setting\Model\SmsGateway;
use SoapClient;
use Twilio\Rest\Client;

trait SendSMS
{
    public function sendIndividualSMS($number, $text)
    {
        $apy_key = env('SMS_API_KEY');

        try {
            $soapClient = new SoapClient('https://api2.onnorokomSMS.com/sendSMS.asmx?wsdl');
            $paramArray = [
                'apiKey' => $apy_key,
                'messageText' => $text,
                'numberList' => $number,
                'smsType' => 'TEXT',
                'maskName' => '',
                'campaignName' => '',
            ];
            $value = $soapClient->__call('NumberSms', [$paramArray]);

            return $value;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function sendSMS($to, $text)
    {
        if (SmsGateway::where('name', 'Twillo')->first()->status) {
            $sid = env('TWILIO_SID'); // Your Account SID from www.twilio.com/console
            $token = env('TWILIO_TOKEN'); // Your Auth Token from www.twilio.com/console

            $client = new Client($sid, $token);

            try {
                $message = $client->messages->create(
                    $to, // Text this number
                  [
                      'from' => env('VALID_TWILLO_NUMBER'), // From a valid Twilio number
                      'body' => $text,
                  ]
                );
            } catch (Exception $e) {
            }
        } elseif (SmsGateway::where('name', 'Text to Local')->first()->status) {
            // Account details
            $apiKey = urlencode(env('TEXT_TO_LOCAL_API_KEY'));

            // Message details
            $numbers = [$to];
            $sender = urlencode(env('TEXT_TO_LOCAL_SENDER'));
            $message = rawurlencode($text);

            $numbers = implode(',', $numbers);

            // Prepare data for POST request
            $data = ['apikey' => $apiKey, 'numbers' => $numbers, 'sender' => $sender, 'message' => $message];

            // Send the POST request with cURL
            $ch = curl_init('https://api.txtlocal.com/send/');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);

            // Process your response here
            return $response;
        }
    }
}
