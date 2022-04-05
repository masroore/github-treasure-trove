<?php

use Illuminate\Database\Migrations\Migration;

class AddClientBackgroundSettings extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        \Illuminate\Support\Facades\DB::table('settings')->insert([
            [
                'setting_key' => 'client_login_background',
                'setting_value' => '',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
}
