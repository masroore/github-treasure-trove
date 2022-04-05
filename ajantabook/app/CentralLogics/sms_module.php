<?php

namespace App\CentralLogics;

use App\Model\BusinessSetting;
use Exception;
use Illuminate\Support\Facades\Config;
use Nexmo\Laravel\Facade\Nexmo;
use Twilio\Rest\Client;

class sms_module
{
    public static function send($receiver, $otp)
    {
        $config = self::get_settings('twilio_sms');
        if (isset($config) && 1 == $config['status']) {
            return self::twilio($receiver, $otp);
        }

        $config = self::get_settings('nexmo_sms');
        if (isset($config) && 1 == $config['status']) {
            return self::nexmo($receiver, $otp);
        }

        $config = self::get_settings('2factor_sms');
        if (isset($config) && 1 == $config['status']) {
            return self::two_factor($receiver, $otp);
        }

        $config = self::get_settings('msg91_sms');
        if (isset($config) && 1 == $config['status']) {
            return self::msg_91($receiver, $otp);
        }

        return 'not_found';
    }

    public static function twilio($receiver, $otp)
    {
        $config = self::get_settings('twilio_sms');
        $response = 'error';
        if (isset($config) && 1 == $config['status']) {
            $message = str_replace('#OTP#', $otp, $config['otp_template']);
            $sid = $config['sid'];
            $token = $config['token'];

            try {
                $twilio = new Client($sid, $token);
                $twilio->messages
                    ->create(
                        $receiver, // to
                        [
                            'messagingServiceSid' => $config['messaging_service_sid'],
                            'body' => $message,
                        ]
                    );
                $response = 'success';
            } catch (Exception $exception) {
                $response = 'error';
            }
        }

        return $response;
    }

    public static function nexmo($receiver, $otp)
    {
        $sms_nexmo = self::get_settings('nexmo_sms');
        $response = 'error';
        if (isset($sms_nexmo) && 1 == $sms_nexmo['status']) {
            $message = str_replace('#OTP#', $otp, $sms_nexmo['otp_template']);

            try {
                $config = [
                    'api_key' => $sms_nexmo['api_key'],
                    'api_secret' => $sms_nexmo['api_secret'],
                    'signature_secret' => '',
                    'private_key' => '',
                    'application_id' => '',
                    'app' => ['name' => '', 'version' => ''],
                    'http_client' => '',
                ];
                Config::set('nexmo', $config);
                Nexmo::message()->send([
                    'to' => $receiver,
                    'from' => $sms_nexmo['from'],
                    'text' => $message,
                ]);
                $response = 'success';
            } catch (Exception $exception) {
                $response = 'error';
            }
        }

        return $response;
    }

    public static function two_factor($receiver, $otp)
    {
        $config = self::get_settings('2factor_sms');
        $response = 'error';
        if (isset($config) && 1 == $config['status']) {
            $api_key = $config['api_key'];
            $curl = curl_init();
            curl_setopt_array($curl, [
                \CURLOPT_URL => 'https://2factor.in/API/V1/' . $api_key . '/SMS/' . $receiver . '/' . $otp . '',
                \CURLOPT_RETURNTRANSFER => true,
                \CURLOPT_ENCODING => '',
                \CURLOPT_MAXREDIRS => 10,
                \CURLOPT_TIMEOUT => 30,
                \CURLOPT_HTTP_VERSION => \CURL_HTTP_VERSION_1_1,
                \CURLOPT_CUSTOMREQUEST => 'GET',
            ]);
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);

            if (!$err) {
                $response = 'success';
            } else {
                $response = 'error';
            }
        }

        return $response;
    }

    public static function msg_91($receiver, $otp)
    {
        $config = self::get_settings('msg91_sms');
        $response = 'error';
        if (isset($config) && 1 == $config['status']) {
            $receiver = str_replace('+', '', $receiver);
            $curl = curl_init();
            curl_setopt_array($curl, [
                \CURLOPT_URL => 'https://api.msg91.com/api/v5/otp?template_id=' . $config['template_id'] . '&mobile=' . $receiver . '&authkey=' . $config['authkey'] . '',
                \CURLOPT_RETURNTRANSFER => true,
                \CURLOPT_ENCODING => '',
                \CURLOPT_MAXREDIRS => 10,
                \CURLOPT_TIMEOUT => 30,
                \CURLOPT_HTTP_VERSION => \CURL_HTTP_VERSION_1_1,
                \CURLOPT_CUSTOMREQUEST => 'GET',
                \CURLOPT_POSTFIELDS => "{\"OTP\":\"$otp\"}",
                \CURLOPT_HTTPHEADER => [
                    'content-type: application/json',
                ],
            ]);
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if (!$err) {
                $response = 'success';
            } else {
                $response = 'error';
            }
        }

        return $response;
    }

    public static function get_settings($name)
    {
        $config = null;
        $data = BusinessSetting::where(['key' => $name])->first();
        if (isset($data)) {
            $config = json_decode($data['value'], true);
            if (null === $config) {
                $config = $data['value'];
            }
        }

        return $config;
    }
}
