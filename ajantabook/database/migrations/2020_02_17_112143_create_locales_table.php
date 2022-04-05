<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLocalesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('locales')) {
            Schema::create('locales', function (Blueprint $table): void {
                $table->increments('id');
                $table->string('lang_code', 191)->nullable();
                $table->string('name', 191)->nullable();
                $table->integer('def')->unsigned()->default(0);
                $table->integer('status')->unsigned()->default(0);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('locales');
    }
}
