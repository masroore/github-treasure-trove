<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductItemDetailsPartNumbersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_item_details_part_numbers', function (Blueprint $table): void {
            $table->id();
            $table->integer('part_number_id')->nullable()->unsigned();
            $table->integer('sale_id')->nullable()->unsigned();
            $table->integer('product_item_detail_id')->nullable()->unsigned();
            $table->integer('product_sku_id')->nullable()->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_item_details_part_numbers');
    }
}
