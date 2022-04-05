<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempCustomerDetailsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('temp_customer_details', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->string('php_session_id', 255)->default(null)->nullable();
            $table->string('first_name', 255)->default(null)->nullable();
            $table->string('last_name', 255)->default(null)->nullable();
            $table->string('address_1', 255)->default(null)->nullable();
            $table->string('address_2', 255)->default(null)->nullable();
            $table->string('email', 255)->default(null)->nullable();
            $table->string('postcode', 255)->default(null)->nullable();
            $table->string('phone', 255)->default(null)->nullable();
            $table->string('payment_first_name', 255)->default(null)->nullable();
            $table->string('payment_last_name', 255)->default(null)->nullable();
            $table->string('payment_company', 255)->default(null)->nullable();
            $table->string('payment_address_1', 255)->default(null)->nullable();
            $table->string('payment_address_2', 255)->default(null)->nullable();
            $table->string('payment_city', 255)->default(null)->nullable();
            $table->string('payment_region', 255)->default(null)->nullable();
            $table->string('payment_postcode', 255)->default(null)->nullable();
            $table->string('payment_country_name', 255)->default(null)->nullable();
            $table->string('payment_method', 255)->default(null)->nullable();
            $table->string('payment_unique_code', 255)->default(null)->nullable();
            $table->string('shipping_first_name', 255)->default(null)->nullable();
            $table->string('shipping_last_name', 255)->default(null)->nullable();
            $table->string('shipping_company', 255)->default(null)->nullable();
            $table->string('shipping_address_1', 255)->default(null)->nullable();
            $table->string('shipping_address_2', 255)->default(null)->nullable();
            $table->string('shipping_city', 255)->default(null)->nullable();
            $table->string('shipping_region', 255)->default(null)->nullable();
            $table->string('shipping_postcode', 255)->default(null)->nullable();
            $table->string('shipping_country_name', 255)->default(null)->nullable();
            $table->string('shipping_method', 255)->default(null)->nullable();
            $table->string('shipping_unique_code', 255)->default(null)->nullable();
            $table->string('shipping_tracking_code', 255)->default(null)->nullable();
            $table->text('comment')->default(null)->nullable();
            $table->string('status', 255)->default(null)->nullable();
            $table->string('currency_code', 255)->default(null)->nullable();
            $table->string('currency_value', 255)->default(null)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temp_customer_details');
    }
}
