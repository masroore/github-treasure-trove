<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderProductOptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_product_option', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('order_id')->nullable()->default(null);
            $table->unsignedBigInteger('order_product_id')->nullable()->default(null);
            $table->unsignedBigInteger('product_option_id')->nullable()->default(null);
            $table->unsignedBigInteger('product_option_value_id')->nullable()->default(null);

            $table->string('name')->nullable()->default(null);
            $table->string('value')->nullable()->default(null);
            $table->string('type')->nullable()->default(null);

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
        Schema::dropIfExists('order_product_option');
    }
}
