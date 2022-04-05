<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductDeliverytimeTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_deliverytime', function (Blueprint $table): void {
            $table->integer('id')->autoIncrement();
            $table->integer('products_id')->default(null)->nullable();
            $table->integer('shipping_delivery_times_id')->default(null)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_deliverytime');
    }
}
