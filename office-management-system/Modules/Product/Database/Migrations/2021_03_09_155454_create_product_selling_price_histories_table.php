<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSellingPriceHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_selling_price_histories', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('product_sku_id')->nullable();
            $table->unsignedBigInteger('purchase_order_id')->nullable();
            $table->Double('old_price', 28, 2)->default(0);
            $table->Double('new_selling_price', 28, 2)->default(0);
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_selling_price_histories');
    }
}
