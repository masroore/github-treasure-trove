<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('customer_id')->default(null)->nullable();
            $table->string('invoice_number')->nullable()->default(null);
            $table->string('invoice_prefix')->default('speedy-order-');
            $table->string('first_name')->default(null)->nullable();
            $table->string('last_name')->default(null)->nullable();
            $table->string('address1')->default(null)->nullable();
            $table->string('address2')->default(null)->nullable();
            $table->string('email')->default(null)->nullable();
            $table->string('postal_code')->default(null)->nullable();
            $table->string('phone')->default(null)->nullable();
            $table->string('payment_first_name')->default(null)->nullable();
            $table->string('payment_last_name')->default(null)->nullable();
            $table->string('payment_company')->default(null)->nullable();
            $table->string('payment_address1')->default(null)->nullable();
            $table->string('payment_address2')->default(null)->nullable();
            $table->string('payment_city')->default(null)->nullable();
            $table->string('payment_postalcode')->default(null)->nullable();
            $table->string('payment_country_name')->default(null)->nullable();
            $table->string('payment_region')->default(null)->nullable();
            $table->string('payment_method')->default(null)->nullable();
            $table->string('payment_unique_code')->default(null)->nullable();

            $table->string('shipping_first_name')->default(null)->nullable();
            $table->string('shipping_last_name')->default(null)->nullable();
            $table->string('shipping_company')->default(null)->nullable();
            $table->string('shipping_address1')->default(null)->nullable();
            $table->string('shipping_address2')->default(null)->nullable();
            $table->string('shipping_city')->default(null)->nullable();
            $table->string('shipping_postalcode')->default(null)->nullable();
            $table->string('shipping_country_name')->default(null)->nullable();
            $table->string('shipping_region')->default(null)->nullable();
            $table->string('shipping_method')->default(null)->nullable();
            $table->string('shipping_unique_code')->default(null)->nullable();
            $table->string('shipping_tracking_code')->default(null)->nullable();

            $table->text('comment')->nullable()->default(null);
            $table->string('status')->default('initiated')->comment('initiated', 'processing', 'pending', 'processed', 'completed', 'delivered', 'denied', 'expired', 'expired', 'failed', 'refunded', 'reversed', 'shipped', 'missing_orders', 'cancelled', 'cancelled_reversal', 'completed', 'chargeback', 'voided');
            $table->float('commisison', 13, 2)->default('0.00')->nullable();

            $table->string('currency_code')->default('usd')->nullable();
            $table->float('currency_value')->comment('if other than usd 1usd equals')->nullable()->default(null);

            $table->string('ip')->default(null)->nullable();
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
        Schema::dropIfExists('orders');
    }
}
