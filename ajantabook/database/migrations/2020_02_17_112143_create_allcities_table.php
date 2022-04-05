<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAllcitiesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('allcities')) {
            Schema::create('allcities', function (Blueprint $table): void {
                $table->increments('id');
                $table->string('name', 30);
                $table->integer('state_id');
                $table->integer('pincode')->nullable();
                $table->dateTime('updated_at')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('allcities');
    }
}
