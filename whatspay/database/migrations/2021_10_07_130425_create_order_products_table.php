<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderProductsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_products', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->bigInteger('order_id')->unsigned()->index('order_product_order_id_index')->comment('Belongs to users table pk');
            $table->bigInteger('product_id')->unsigned()->index('order_product_product_id_index')->comment('Belongs to stores table pk');
            $table->string('product_name', 256)->nullable();
            $table->Integer('qty');
            $table->float('price', 15, 2)->nullable();
            $table->float('discount_amount', 15, 2)->nullable();
            $table->tinyText('add_ons_detail')->nullable();
            $table->float('add_ons_amount', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_products');
    }
}
