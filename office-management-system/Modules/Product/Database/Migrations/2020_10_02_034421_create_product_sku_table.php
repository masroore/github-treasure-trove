<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSkuTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_sku', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('sku', 250)->nullable();
            $table->unsignedBigInteger('stock_quantity')->nullable();
            $table->unsignedBigInteger('alert_quantity')->nullable();
            $table->double('purchase_price', 16, 2)->default(0);
            $table->double('selling_price', 16, 2)->default(0);
            $table->string('barcode_type', 255)->nullable();
            $table->string('barcode_id')->nullable();
            $table->string('discount_type', 50)->nullable();
            $table->double('discount', 16, 2)->default(0);
            $table->string('tax_type', 50)->nullable();
            $table->double('tax', 16, 2)->default(0);
            $table->double('cost_of_goods', 16, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_sku');
    }
}
