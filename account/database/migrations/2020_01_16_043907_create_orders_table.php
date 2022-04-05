<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->string('order_id', 100)->unique();
            $table->string('name', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('card_number', 10)->nullable();
            $table->string('card_exp_month', 10)->nullable();
            $table->string('card_exp_year', 10)->nullable();
            $table->string('plan_name', 100);
            $table->integer('plan_id');
            $table->float('price');
            $table->string('price_currency', 10);
            $table->string('txn_id', 100);
            $table->string('payment_status', 100);
            $table->string('receipt')->nullable();
            $table->integer('user_id')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
}
