<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartPaymentTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cart_payment', function (Blueprint $table): void {
            $table->increments('id');
            $table->unsignedInteger('cart_id');
            $table->enum('payment_type', ['voucher', 'visa', 'mastercard', 'american_express']);
            $table->string('payment_uuid')->nullable();
            $table->string('description');
            $table->decimal('old_balance', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->decimal('iva', 10, 2);
            $table->decimal('total', 10, 2);
            $table->decimal('new_balance', 10, 2);
            $table->string('receipt');
            $table->timestamps();

            $table->foreign('cart_id')
                ->references('id')->on('cart')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_payment');
    }
}
