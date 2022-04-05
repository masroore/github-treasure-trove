<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ticketit_settings', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('lang')->unique()->nullable();
            $table->string('slug')->unique()->index();
            $table->string('value');
            $table->string('default');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('ticketit_settings');
    }
}
