<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductWithAttributesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_with_attributes', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->bigInteger('attribute_id')->unsigned()->index('p_with_attr_attribute_id_index')->comment('Belongs to product_attributes');
            $table->bigInteger('product_id')->unsigned()->index('p_with_attr_product_id_index')->comment('Belongs to products table');
            $table->foreign('attribute_id')
                ->references('id')
                ->on('product_attributes')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_with_attributes');
        Schema::table('product_with_attributes', function (Blueprint $table): void {
            $table->dropSoftDeletes();
        });
    }
}
