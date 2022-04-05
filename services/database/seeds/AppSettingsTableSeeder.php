<?php
/*
 * File name: AppSettingsTableSeeder.php
 * Last modified: 2021.11.02 at 13:04:47
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */

use Illuminate\Database\Seeder;

class AppSettingsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('app_settings')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('app_settings')->insert([
            [
                'id' => 7,
                'key' => 'date_format',
                'value' => 'l jS F Y (H:i:s)',
            ],
            [
                'id' => 8,
                'key' => 'language',
                'value' => 'en',
            ],
            [
                'id' => 17,
                'key' => 'is_human_date_format',
                'value' => '1',
            ],
            [
                'id' => 18,
                'key' => 'app_name',
                'value' => 'Home Services',
            ],
            [
                'id' => 19,
                'key' => 'app_short_description',
                'value' => 'Manage Mobile Application',
            ],
            [
                'id' => 20,
                'key' => 'mail_driver',
                'value' => 'smtp',
            ],
            [
                'id' => 21,
                'key' => 'mail_host',
                'value' => 'smtp.hostinger.com',
            ],
            [
                'id' => 22,
                'key' => 'mail_port',
                'value' => '587',
            ],
            [
                'id' => 23,
                'key' => 'mail_username',
                'value' => 'test@demo.com',
            ],
            [
                'id' => 24,
                'key' => 'mail_password',
                'value' => '-',
            ],
            [
                'id' => 25,
                'key' => 'mail_encryption',
                'value' => 'ssl',
            ],
            [
                'id' => 26,
                'key' => 'mail_from_address',
                'value' => 'test@demo.com',
            ],
            [
                'id' => 27,
                'key' => 'mail_from_name',
                'value' => 'Smarter Vision',
            ],
            [
                'id' => 30,
                'key' => 'timezone',
                'value' => 'America/Montserrat',
            ],
            [
                'id' => 32,
                'key' => 'theme_contrast',
                'value' => 'light',
            ],
            [
                'id' => 33,
                'key' => 'theme_color',
                'value' => 'primary',
            ],
            [
                'id' => 34,
                'key' => 'app_logo',
                'value' => '020a2dd4-4277-425a-b450-426663f52633',
            ],
            [
                'id' => 35,
                'key' => 'nav_color',
                'value' => 'navbar-dark navbar-navy',
            ],
            [
                'id' => 38,
                'key' => 'logo_bg_color',
                'value' => 'text-light  navbar-navy',
            ],
            [
                'id' => 66,
                'key' => 'default_role',
                'value' => 'admin',
            ],
            [
                'id' => 68,
                'key' => 'facebook_app_id',
                'value' => '518416208939727',
            ],
            [
                'id' => 69,
                'key' => 'facebook_app_secret',
                'value' => '93649810f78fa9ca0d48972fee2a75cd',
            ],
            [
                'id' => 71,
                'key' => 'twitter_app_id',
                'value' => 'twitter',
            ],
            [
                'id' => 72,
                'key' => 'twitter_app_secret',
                'value' => 'twitter 1',
            ],
            [
                'id' => 74,
                'key' => 'google_app_id',
                'value' => '527129559488-roolg8aq110p8r1q952fqa9tm06gbloe.apps.googleusercontent.com',
            ],
            [
                'id' => 75,
                'key' => 'google_app_secret',
                'value' => 'FpIi8SLgc69ZWodk-xHaOrxn',
            ],
            [
                'id' => 77,
                'key' => 'enable_google',
                'value' => '1',
            ],
            [
                'id' => 78,
                'key' => 'enable_facebook',
                'value' => '1',
            ],
            [
                'id' => 93,
                'key' => 'enable_stripe',
                'value' => '1',
            ],
            [
                'id' => 94,
                'key' => 'stripe_key',
                'value' => 'pk_test_pltzOnX3zsUZMoTTTVUL4O41',
            ],
            [
                'id' => 95,
                'key' => 'stripe_secret',
                'value' => 'sk_test_o98VZx3RKDUytaokX4My3a20',
            ],
            [
                'id' => 101,
                'key' => 'custom_field_models.0',
                'value' => 'App\\Models\\User',
            ],
            [
                'id' => 104,
                'key' => 'default_tax',
                'value' => '10',
            ],
            [
                'id' => 107,
                'key' => 'default_currency',
                'value' => '$',
            ],
            [
                'id' => 108,
                'key' => 'fixed_header',
                'value' => '1',
            ],
            [
                'id' => 109,
                'key' => 'fixed_footer',
                'value' => '0',
            ],
            [
                'id' => 110,
                'key' => 'fcm_key',
                'value' => 'AAAAHMZiAQA:APA91bEb71b5sN5jl-w_mmt6vLfgGY5-_CQFxMQsVEfcwO3FAh4-mk1dM6siZwwR3Ls9U0pRDpm96WN1AmrMHQ906GxljILqgU2ZB6Y1TjiLyAiIUETpu7pQFyicER8KLvM9JUiXcfWK',
            ],
            [
                'id' => 111,
                'key' => 'enable_notifications',
                'value' => '1',
            ],
            [
                'id' => 112,
                'key' => 'paypal_username',
                'value' => 'sb-z3gdq482047_api1.business.example.com',
            ],
            [
                'id' => 113,
                'key' => 'paypal_password',
                'value' => '-',
            ],
            [
                'id' => 114,
                'key' => 'paypal_secret',
                'value' => '-',
            ],
            [
                'id' => 115,
                'key' => 'enable_paypal',
                'value' => '1',
            ],
            [
                'id' => 116,
                'key' => 'main_color',
                'value' => '#F4841F',
            ],
            [
                'id' => 117,
                'key' => 'main_dark_color',
                'value' => '#F4841F',
            ],
            [
                'id' => 118,
                'key' => 'second_color',
                'value' => '#08143A',
            ],
            [
                'id' => 119,
                'key' => 'second_dark_color',
                'value' => '#CCCCDD',
            ],
            [
                'id' => 120,
                'key' => 'accent_color',
                'value' => '#8C9DA8',
            ],
            [
                'id' => 121,
                'key' => 'accent_dark_color',
                'value' => '#9999AA',
            ],
            [
                'id' => 122,
                'key' => 'scaffold_dark_color',
                'value' => '#2C2C2C',
            ],
            [
                'id' => 123,
                'key' => 'scaffold_color',
                'value' => '#FAFAFA',
            ],
            [
                'id' => 124,
                'key' => 'google_maps_key',
                'value' => '-',
            ],
            [
                'id' => 125,
                'key' => 'mobile_language',
                'value' => 'en',
            ],
            [
                'id' => 126,
                'key' => 'app_version',
                'value' => '1.0.0',
            ],
            [
                'id' => 127,
                'key' => 'enable_version',
                'value' => '1',
            ],
            [
                'id' => 128,
                'key' => 'default_currency_id',
                'value' => '1',
            ],
            [
                'id' => 129,
                'key' => 'default_currency_code',
                'value' => 'USD',
            ],
            [
                'id' => 130,
                'key' => 'default_currency_decimal_digits',
                'value' => '2',
            ],
            [
                'id' => 131,
                'key' => 'default_currency_rounding',
                'value' => '0',
            ],
            [
                'id' => 132,
                'key' => 'currency_right',
                'value' => '1',
            ],
            [
                'id' => 133,
                'key' => 'distance_unit',
                'value' => 'km',
            ],
            [
                'id' => 134,
                'key' => 'default_theme',
                'value' => 'light',
            ],
            [
                'id' => 135,
                'key' => 'enable_paystack',
                'value' => '1',
            ],
            [
                'id' => 136,
                'key' => 'paystack_key',
                'value' => 'pk_test_d754715fa3fa9048c9ab2832c440fb183d7c91f5',
            ],
            [
                'id' => 137,
                'key' => 'paystack_secret',
                'value' => 'sk_test_66f87edaac94f8adcb28fdf7452f12ccc63d068d',
            ], [
                'id' => 138,
                'key' => 'enable_flutterwave',
                'value' => '1',
            ],
            [
                'id' => 139,
                'key' => 'flutterwave_key',
                'value' => 'FLWPUBK_TEST-d465ba7e4f6b86325cb9881835726402-X',
            ],
            [
                'id' => 140,
                'key' => 'flutterwave_secret',
                'value' => 'FLWSECK_TEST-d3f8801da31fc093fb1207ea34e68fbb-X',
            ],
            [
                'id' => 141,
                'key' => 'enable_stripe_fpx',
                'value' => '1',
            ],
            [
                'id' => 142,
                'key' => 'stripe_fpx_key',
                'value' => 'pk_test_51IQ0zvB0wbAJesyPLo3x4LRgOjM65IkoO5hZLHOMsnO2RaF0NlH7HNOfpCkjuLSohvdAp30U5P1wKeH98KnwXkOD00mMDavaFX',
            ],
            [
                'id' => 143,
                'key' => 'stripe_fpx_secret',
                'value' => 'sk_test_51IQ0zvB0wbAJesyPUtR7yGdyOR7aGbMQAX5Es9P56EDUEsvEQAC0NBj7JPqFuJEYXrvSCm5OPRmGaUQBswjkRxVB00mz8xhkFX',
            ],
            [
                'id' => 144,
                'key' => 'enable_paymongo',
                'value' => '1',
            ],
            [
                'id' => 145,
                'key' => 'paymongo_key',
                'value' => 'pk_test_iD6aYYm4yFuvkuisyU2PGSYH',
            ],
            [
                'id' => 146,
                'key' => 'paymongo_secret',
                'value' => 'sk_test_oxD79bMKxb8sA47ZNyYPXwf3',
            ],
        ]);
    }
}
