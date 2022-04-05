<?php

use Illuminate\Database\Migrations\Migration;

class AddOverdrawSettings extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        \Illuminate\Support\Facades\DB::table('settings')->insert([
            [
                'setting_key' => 'allow_bank_overdraw',
                'setting_value' => '0',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        App\Models\Setting::where('setting_key', 'allow_bank_overdraw')
            ->delete();
    }
}
