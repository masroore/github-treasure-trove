<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTaxesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('taxes')) {
            Schema::create('taxes', function (Blueprint $table): void {
                $table->increments('id');
                $table->string('name', 191)->nullable();
                $table->integer('zone_id')->nullable();
                $table->string('rate', 191)->nullable();
                $table->enum('type', ['p', 'f']);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('taxes');
    }
}
