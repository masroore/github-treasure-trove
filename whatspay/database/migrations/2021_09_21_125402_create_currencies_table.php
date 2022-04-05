<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('currencies', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->string('title', 191)->nullable();
            $table->string('symbol', 10)->nullable();
            $table->tinyInteger('is_prefix_symbol')->default(0);
            $table->tinyInteger('decimals')->default(0);
            $table->Integer('order')->default(0);
            $table->tinyInteger('is_default')->default(0);
            $table->double('exchange_rate', 15, 8);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currencies');
        Schema::table('currencies', function (Blueprint $table): void {
            $table->dropSoftDeletes();
        });
    }
}
