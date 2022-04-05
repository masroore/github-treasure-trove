<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table): void {
            $table->id();
            $table->string('product_name')->nullable();
            $table->string('product_type')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->unsignedBigInteger('unit_type_id')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('sub_category_id')->nullable();
            $table->string('origin')->nullable();
            $table->text('description')->nullable();
            $table->string('image_source')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->on('users')->references('id')->onDelete('cascade');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->on('users')->references('id')->onDelete('cascade');
            $table->timestamps();
            $table->string('product_sku')->nullable();
            $table->string('barcode_type')->nullable();
            $table->double('price', 16, 2)->nullable();
            $table->string('price_of_other_currency')->nullable();
            $table->unsignedBigInteger('ware_house_id')->nullable();
            $table->boolean('manage_stock')->default(0);
            $table->string('alert_quantity')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     *\ @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
}
