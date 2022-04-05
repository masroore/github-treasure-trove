<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAllstatesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('allstates')) {
            Schema::create('allstates', function (Blueprint $table): void {
                $table->increments('id');
                $table->string('name', 30);
                $table->integer('country_id')->default(1);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('allstates');
    }
}
