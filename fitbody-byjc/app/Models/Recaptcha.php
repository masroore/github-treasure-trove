<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;

class Recaptcha
{
    /**
     * @var string
     */
    private $remote_ip;

    /**
     * @var string
     */
    private $verify_url;

    /**
     * @var object
     */
    private $result;

    /**
     * Recaptcha constructor.
     */
    public function __construct()
    {
        $this->remote_ip = $_SERVER['REMOTE_ADDR'];
        $this->verify_url = config('services.recaptcha.verify_url');
    }

    /**
     * @return bool|mixed
     */
    public function check(array $data)
    {
        if (isset($data['recaptcha'])) {
            $_data = $this->setContentData($data['recaptcha']);
            $options = $this->setOptions($_data);

            Log::debug($options);

            $context = stream_context_create($options);
            Log::debug($context);
            $result = file_get_contents($this->verify_url, false, $context);
            Log::debug($result);
            $this->result = json_decode($result);

            return $this;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function ok()
    {
        if (true != $this->result->success || $this->result->score < 0.3) {
            return false;
        }

        return true;
    }

    /**
     * @return array
     */
    private function setContentData(string $recaptcha)
    {
        return [
            'secret'   => config('services.recaptcha.secret'),
            'response' => $recaptcha,
            'remoteip' => $this->remote_ip,
        ];
    }

    /**
     * @return array[]
     */
    private function setOptions(array $data)
    {
        return [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
            ],
        ];
    }
}
