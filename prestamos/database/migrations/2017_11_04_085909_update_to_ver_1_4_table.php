<?php

use Illuminate\Database\Migrations\Migration;

class UpdateToVer14Table extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        App\Models\Setting::where('setting_key', 'system_version')
            ->update(['setting_value' => '1.4']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
}
