<?php

use Illuminate\Database\Migrations\Migration;

class AddV12Settings extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        \Illuminate\Support\Facades\DB::table('settings')->insert([
            [
                'setting_key' => 'update_url',
                'setting_value' => 'http://webstudio.co.zw/ultimateloanmanager/updates/ver.php',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        App\Models\Setting::where('setting_key', 'update_url')
            ->delete();
    }
}
