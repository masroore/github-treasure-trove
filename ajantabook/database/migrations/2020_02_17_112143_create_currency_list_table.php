<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCurrencyListTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('currency_list')) {
            Schema::create('currency_list', function (Blueprint $table): void {
                $table->integer('id', true);
                $table->string('country', 191)->nullable();
                $table->string('currency_list', 191)->nullable();
                $table->string('code', 191)->nullable();
                $table->string('symbol', 191)->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('currency_list');
    }
}
