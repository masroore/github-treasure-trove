<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCurrencyCheckoutsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('currency_checkouts')) {
            Schema::create('currency_checkouts', function (Blueprint $table): void {
                $table->increments('id');
                $table->integer('multicurrency_id')->nullable();
                $table->string('currency', 191)->nullable();
                $table->enum('default', ['0', '1'])->default('0');
                $table->string('checkout_currency', 191)->nullable();
                $table->string('payment_method', 191)->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('currency_checkouts');
    }
}
