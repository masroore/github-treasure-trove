<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderPaymentsExtraDetailsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_payments_extra_details', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->bigInteger('order_id')->unsigned()->index('order_id_order_payments_extra_detail_index')->comment('Belongs to orders table');
            $table->bigInteger('customer_id')->unsigned()->index('customer_id_order_payment_extra_index')->comment('Belongs to id of users table');
            $table->bigInteger('store_id')->unsigned()->index('store_id_order_payment_extra_index')->comment('Belongs to store table');
            $table->text('description')->nullable();
            $table->longText('payment_detail')->nullable();
            $table->foreign('customer_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreign('store_id')
                ->references('id')
                ->on('stores')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_payments_extra_details');
    }
}
