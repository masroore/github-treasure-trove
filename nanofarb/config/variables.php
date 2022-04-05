<?php

/*
|--------------------------------------------------------------------------
|  Laravel Variables
|--------------------------------------------------------------------------
|
*/
return [

    'model' => \Fomvasss\Variable\Variable::class,

    'table_name' => 'variables',

    /* -----------------------------------------------------------------
     |  Root key for config, example: 'vars'
     |  Use: config('vars.some_var')
     |  If empty this - option OFF
     | -----------------------------------------------------------------
     */
    'config_key_for_vars' => 'vars',

    /* -----------------------------------------------------------------
     |  Replace configs with variables
     | -----------------------------------------------------------------
     */
    'variable_config' => [
        'app_name' => 'app.name',                   // config('app.name')
        'mail_from_address' => 'mail.from.address',
        'mail_from_name' => 'mail.from.name',

        'web_forms_phone_placeholder' => 'web-forms.phone.placeholder',
        'web_forms_phone_mask' => 'web-forms.phone.mask',

        'cdek_account' => 'services.cdek.account',
        'cdek_password' => 'services.cdek.password',

        'sendpulse_user_id' => 'sendpulse.api_user_id',
        'sendpulse_secret' => 'sendpulse.api_secret',

        'bitrix24_host' => 'services.bitrix24.host',
        'bitrix24_user' => 'services.bitrix24.user',
        'bitrix24_hook_code' => 'services.bitrix24.hook_code',

        'google_captcha_secret' => 'captcha.secret',
        'google_captcha_sitekey' => 'captcha.sitekey',
    ],

    /* -----------------------------------------------------------------
     |  Cache settings for vars
     | -----------------------------------------------------------------
     */
    'cache' => [

        'time' => 360,

        'name' => 'laravel.variables.cache',
    ],

    'localable' => [
        'company_work_schedule', 'delivery_pickup_address', 'delivery_novaposhta_courier_desc',
        'product_cart_icons',
        'phones_header',
        'company_name', 'company_email', 'company_phone', 'company_address',
        'company_schedule_map', 'company_schedule_footer',
        'page_home_titles', 'contact_latitude', 'contact_longitude',
    ],
];
