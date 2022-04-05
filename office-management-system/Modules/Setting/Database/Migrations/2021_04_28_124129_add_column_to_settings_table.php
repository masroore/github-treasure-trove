<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('general_settings', function (Blueprint $table): void {
            $table->string('login_bg')->default('public/backEnd/img/login-bg.png');
            $table->string('error_page_bg')->default('public/backEnd/img/login-bg.jpg');
            $table->string('default_view')->default('normal');
        });

        \Illuminate\Support\Facades\DB::table('business_settings')->insert([
            [
                'category_type' => null,
                'type' => 'system_registration',
                'status' => '0',
                'created_at' => date('Y-m-d h:i:s'),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table): void {
        });
    }
}
