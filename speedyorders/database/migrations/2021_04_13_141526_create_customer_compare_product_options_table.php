<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerCompareProductOptionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customer_compare_product_options', function (Blueprint $table): void {
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
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_compare_product_options');
    }
}
