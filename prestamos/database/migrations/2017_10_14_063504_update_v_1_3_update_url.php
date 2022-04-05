<?php

use Illuminate\Database\Migrations\Migration;

class UpdateV13UpdateUrl extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        App\Models\Setting::where('setting_key', 'update_url')
            ->update(['setting_value' => 'http://webstudio.co.zw/ulm/update']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
}
