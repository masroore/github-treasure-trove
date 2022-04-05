<?php

use Illuminate\Database\Migrations\Migration;

class ChangeUpdateUrl extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        App\Models\Setting::where('setting_key', 'update_url')
            ->update(['setting_value' => 'http://webstudio.co.zw/ultimateloanmanager/updates/ver']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
}
