<?php

namespace App\Helpers;

use Config;
use Str;

class Encryptor
{
    public static function method()
    {
        return Config::get('app.cipher');
    }

    public static function hash_key()
    {
        return hash('sha256', Str::substr(Config::get('app.key'), 7));
    }

    public static function iv()
    {
        $secret_iv = Str::substr(Config::get('app.key'), 7);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        return $iv;
    }

    public static function encrypt($value)
    {
        $output = openssl_encrypt($value, self::method(), self::hash_key(), 0, self::iv());
        $output = base64_encode($output);

        return $output;
    }

    public static function decrypt($value)
    {
        $output = openssl_decrypt(base64_decode($value), self::method(), self::hash_key(), 0, self::iv());

        return (int) $output;
    }
}
