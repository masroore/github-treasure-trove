<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductOptionValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_option_values', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('product_option_id')->default(null)->nullable();
            $table->unsignedBigInteger('option_id')->nullable()->default(null);
            $table->unsignedBigInteger('option_value_id')->nullable()->default(null);
            $table->integer('quantity')->nullable()->default(null);
            $table->integer('subtract_from_stock')->nullable()->default(null);
            $table->float('price', 13, 2)->default(null)->nullable();
            $table->boolean('price_prefix')->comment('1=>add,0=>subtract')->default(null)->nullable();
            $table->string('input_value')->nullable()->default(null);
            $table->string('status')->default('1')->comment('1=>show option,0=>do not show')->nullable();
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
        Schema::dropIfExists('product_option_values');
    }
}
