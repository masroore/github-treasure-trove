<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUnitValuesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('unit_values')) {
            Schema::create('unit_values', function (Blueprint $table): void {
                $table->increments('id');
                $table->string('unit_values', 191);
                $table->string('short_code', 191)->nullable();
                $table->integer('unit_id')->unsigned();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('unit_values');
    }
}
