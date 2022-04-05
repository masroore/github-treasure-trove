<?php

use Illuminate\Database\Migrations\Migration;

class AddCurrentThemeToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        \Illuminate\Support\Facades\DB::table('settings')->insert([
            [
                'setting_key' => 'active_theme',
                'setting_value' => 'limitless',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        App\Models\Setting::where('setting_key', 'active_theme')
            ->delete();
    }
}
