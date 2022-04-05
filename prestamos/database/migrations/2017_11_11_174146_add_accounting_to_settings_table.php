<?php

use Illuminate\Database\Migrations\Migration;

class AddAccountingToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        \Illuminate\Support\Facades\DB::table('settings')->insert([
            [
                'setting_key' => 'expenses_chart_id',
                'setting_value' => '',
            ],
            [
                'setting_key' => 'income_chart_id',
                'setting_value' => '',
            ],
            [
                'setting_key' => 'payroll_chart_id',
                'setting_value' => '',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        App\Models\Setting::where('setting_key', 'expenses_chart_id')
            ->delete();
        App\Models\Setting::where('setting_key', 'income_chart_id')
            ->delete();
        App\Models\Setting::where('setting_key', 'payroll_chart_id')
            ->delete();
    }
}
