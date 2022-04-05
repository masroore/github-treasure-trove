<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAllcountryTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('allcountry')) {
            Schema::create('allcountry', function (Blueprint $table): void {
                $table->increments('id');
                $table->char('iso', 2);
                $table->string('name', 80);
                $table->string('nicename', 80);
                $table->char('iso3', 3)->nullable();
                $table->smallInteger('numcode')->nullable();
                $table->integer('phonecode');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('allcountry');
    }
}
