<?php

use Illuminate\Database\Migrations\Migration;

class UpdateToV13 extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        App\Models\Setting::where('setting_key', 'system_version')
            ->update(['setting_value' => '1.3']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
}
