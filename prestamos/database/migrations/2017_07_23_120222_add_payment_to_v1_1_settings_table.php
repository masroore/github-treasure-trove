<?php

use Illuminate\Database\Migrations\Migration;

class AddPaymentToV11SettingsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        \Illuminate\Support\Facades\DB::table('settings')->insert([
            [
                'setting_key' => 'enable_online_payment',
                'setting_value' => '0',
            ],
            [
                'setting_key' => 'paynow_key',
                'setting_value' => '',
            ],
            [
                'setting_key' => 'paynow_id',
                'setting_value' => '',
            ],
            [
                'setting_key' => 'paypal_enabled',
                'setting_value' => '0',
            ],
            [
                'setting_key' => 'paynow_enabled',
                'setting_value' => '0',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        App\Models\Setting::where('setting_key', 'enable_online_payment')
            ->delete();
        App\Models\Setting::where('setting_key', 'paynow_key')
            ->delete();
        App\Models\Setting::where('setting_key', 'paynow_id')
            ->delete();
        App\Models\Setting::where('setting_key', 'paypal_enabled')
            ->delete();
        App\Models\Setting::where('setting_key', 'paynow_enabled')
            ->delete();
    }
}
