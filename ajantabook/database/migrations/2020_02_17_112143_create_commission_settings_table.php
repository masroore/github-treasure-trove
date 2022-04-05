<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommissionSettingsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('commission_settings')) {
            Schema::create('commission_settings', function (Blueprint $table): void {
                $table->increments('id');
                $table->string('rate', 191)->nullable();
                $table->enum('type', ['c', 'flat']);
                $table->enum('p_type', ['p', 'f', '']);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('commission_settings');
    }
}
