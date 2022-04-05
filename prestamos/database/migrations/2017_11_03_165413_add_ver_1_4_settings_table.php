<?php

use Illuminate\Database\Migrations\Migration;

class AddVer14SettingsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        \Illuminate\Support\Facades\DB::table('settings')->insert([
            [
                'setting_key' => 'stripe_secret_key',
                'setting_value' => '',
            ], [
                'setting_key' => 'stripe_publishable_key',
                'setting_value' => '',
            ], [
                'setting_key' => 'stripe_enabled',
                'setting_value' => '0',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        App\Models\Setting::where('setting_key', 'stripe_secret_key')
            ->delete();
        App\Models\Setting::where('setting_key', 'stripe_publishable_key')
            ->delete();
        App\Models\Setting::where('setting_key', 'stripe_enabled')
            ->delete();
    }
}
