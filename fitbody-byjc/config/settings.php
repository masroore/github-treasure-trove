<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, SparkPost and others. This file provides a sane default
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */
    'roles' => [
        'admin' => 'Administrator',
        'editor' => 'Editor',
        'customer' => 'Korisnik',
    ],

    'payments' => [
        'cash' => 'Gotovina',
        'bank' => 'Bankovna Transakcija',
        'card' => 'Kartica',
    ],

    'shipping' => [
        'hand' => 'Osobna dostava',
        'pickup' => 'Osobno podizanje',
        'shipping' => 'Dostava Poštom',
    ],

    'pagination' => [
        'admin' => 20,
        'items' => 12,
    ],

    'category' => [
        'news' => 2,
    ],

];
