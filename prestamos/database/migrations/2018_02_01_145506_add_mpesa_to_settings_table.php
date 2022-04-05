<?php

use Illuminate\Database\Migrations\Migration;

class AddMpesaToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        \Illuminate\Support\Facades\DB::table('settings')->insert([
            [
                'setting_key' => 'mpesa_consumer_key',
                'setting_value' => '',
            ],
            [
                'setting_key' => 'mpesa_consumer_secret',
                'setting_value' => '',
            ],
            [
                'setting_key' => 'mpesa_shortcode',
                'setting_value' => '',
            ],
            [
                'setting_key' => 'mpesa_endpoint',
                'setting_value' => 'https://sandbox.safaricom.co.ke',
            ],
            [
                'setting_key' => 'mpesa_initiator',
                'setting_value' => '',
            ],
            [
                'setting_key' => 'mpesa_enabled',
                'setting_value' => '0',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        App\Models\Setting::where('setting_key', 'mpesa_consumer_key')
            ->delete();
        App\Models\Setting::where('setting_key', 'mpesa_consumer_secret')
            ->delete();
        App\Models\Setting::where('setting_key', 'mpesa_shortcode')
            ->delete();
        App\Models\Setting::where('setting_key', 'mpesa_endpoint')
            ->delete();
        App\Models\Setting::where('setting_key', 'mpesa_initiator')
            ->delete();
        App\Models\Setting::where('setting_key', 'mpesa_enabled')
            ->delete();
    }
}
