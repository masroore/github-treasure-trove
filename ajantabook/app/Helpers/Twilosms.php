<?php

use Twilio\Rest\Client;

class Twilosms
{
    public static function sendMessage($message, $recipients): void
    {
        $account_sid = getenv('TWILIO_SID');
        $auth_token = getenv('TWILIO_AUTH_TOKEN');
        $twilio_number = getenv('TWILIO_NUMBER');
        $client = new Client($account_sid, $auth_token);
        $client->messages->create(
            $recipients,
            ['from' => $twilio_number, 'body' => $message]
        );
    }
}
