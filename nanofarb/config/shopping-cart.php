<?php

return [

    'storage_drivers' => [
        'cookie' => \App\Helpers\ShoppingCart\StorageDrivers\CartCookieStorageDriver::class,

        'eloquent' => \App\Helpers\ShoppingCart\StorageDrivers\CartEloquentStorageDriver::class,
    ],

    'default' => 'eloquent',
];
