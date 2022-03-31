<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_products', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('order_id')->nullable()->default(null);
            $table->unsignedBigInteger('product_id')->nullable()->default(null);
            $table->string('sku')->default(null)->nullable();
            $table->integer('quantity')->default(1)->nullable();
            $table->float('price', 13, 2)->default(0)->nullable();
            $table->float('tax')->default(0)->nullable();
            $table->float('shipping_price', 13, 2)->default(0)->nullable();
            $table->string('status')->default('initiated')->comment('initiated', 'processing', 'pending', 'processed', 'completed', 'delivered', 'denied', 'expired', 'expired', 'failed', 'refunded', 'reversed', 'shipped', 'missing_orders', 'cancelled', 'cancelled_reversal', 'completed', 'chargeback', 'voided');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_products');
    }
}
