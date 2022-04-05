<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'fcm' => [
        'key' => env('FCM_KEY'),
    ],
    'frontUrl' => env('FRONT_URL'),
    //CARS
    'cars' => [
        'serviceToken' => env('CARS_SERVICE_TOKEN'),
        'urlService' => env('URL_CARS_SERVICE'),
        'urlMagazine' => env('URL_MAGAZINE_CATALOG'),
        //        'models' => env('CARS_SERVICES_MODELS'),
        'brand' => env('CARS_SERVICES_BRAND'),
        //        'modelsMagazine' => env('CARS_MAGAZINE_MODELS'),
        //        'brandMagazine' => env('CARS_MAGAZINE_BRAND'),
    ],

    'site' => 'https://cargasm.ru/',
    'orderStatusUrl' => 'https://86.57.162.123:9854/public/admin/orders/statuscheck/',

    //    'github' => [
    //        'client_id' => env('GITHUB_CLIENT_ID'),
    //        'client_secret' => env('GITHUB_CLIENT_SECRET'),
    //        'redirect' => env('GITHUB_REDIRECT'),
    //    ],
    'apple' => [
        'client_id' => env('APPLE_CLIENT_ID'),
        'client_secret' => env('APPLE_CLIENT_SECRET'),
        'redirect' => env('APPLE_REDIRECT_URI'),
        'key_id' => env('APPLE_KEY_ID'),
        'team_id' => env('APPLE_TEAM_ID'),
    ],

    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect' => env('FACEBOOK_REDIRECT_URI'),
    ],
    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI'),
    ],

    'vkontakte' => [
        'client_id' => env('VKONTAKTE_CLIENT_ID'),
        'client_secret' => env('VKONTAKTE_CLIENT_SECRET'),
        'redirect' => env('VKONTAKTE_REDIRECT_URI'),
    ],

    'socialproviders' => [
        'apple',
        'facebook',
        'vkontakte',
        'google',
        //        'github',
    ],

    'recaptcha' => [
        'key' => env('CAPTCHA_SITEKEY'),
        'secret' => env('CAPTCHA_SECRET'),
    ],
];
