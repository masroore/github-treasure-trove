<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerCompareProductOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_compare_product_options', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('customer_compare_product_id')->default(null)->nullable();
            $table->unsignedBigInteger('product_option_id')->default(null)->nullable();
            $table->unsignedBigInteger('product_option_value_id')->default(null)->nullable();
            $table->text('product_option_value')->default(null)->nullable();
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
        Schema::dropIfExists('customer_compare_product_options');
    }
}
