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
            $table->string('reference_no', 255)->nullable();
            $table->Integer('refrence_no_int')->comment('Reference number integer value');
            $table->bigInteger('customer_id')->unsigned()->index('order_customer_id_index')->comment('Belongs to users table pk');
            $table->bigInteger('store_id')->unsigned()->index('order_store_id_index')->comment('Belongs to stores table pk');
            $table->enum('status', ['pending', 'confirmed_by_customer', 'canceled', 'processing', 'delivering', 'completed'])->default('pending');
            $table->float('add_ons_amount', 15, 2)->nullable();
            $table->float('sub_total', 15, 2)->nullable();
            $table->float('shipping_amount', 15, 2)->nullable();
            $table->float('promo_code_amount', 15, 2)->nullable();
            $table->float('discount_amount', 15, 2)->nullable();
            $table->float('service_charges_amount', 15, 2)->nullable();
            $table->float('total_amount', 15, 2)->nullable();
            $table->enum('payment_channel', ['bank_transfer', 'cod', 'paypal'])->default('cod');
            $table->enum('transaction_status', ['pending', 'paid'])->default('pending');
            $table->string('service_option', 50)->nullable();
            $table->string('shipping_address', 256)->nullable();
            $table->string('shipping_city', 50)->nullable();
            $table->string('shipping_country', 50)->nullable();
            $table->string('shipping_latitude', 50)->nullable();
            $table->string('shipping_longitude', 50)->nullable();
            $table->boolean('is_confirmed')->default(0);
            $table->boolean('is_active')->default(0);

            $table->foreign('store_id')
                ->references('id')
                ->on('stores')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('customer_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->timestamps();

            $table->softDeletes();
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
