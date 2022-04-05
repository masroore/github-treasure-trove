<?php

return [
    'name' => 'ExternalShop',

    'drivers' => [
        'prom' => [
            'token' => '',
            'schedule' => '',
        ],
        'rozetka' => [
            'username' => '',
            'password' => '',
            'schedule' => '',
        ],
    ],

    'cron_schedule_expression' => [
        '* * * * *' => 'Каждую мин.',
        '*/5 * * * *' => 'Каждые 5 мин.',
        '0 * * * *' => 'Каждый час',
        '0 */6 * * *' => 'Каждых 6 часов',
        '0 1 * * *' => 'Каждый день в 01:00',
        '0 1 * * 0' => 'Каждое воскресенье в 01:00',
        '0 1 1 * *' => 'Каждую месяц, 1 числа в 01:00',
    ],
];
