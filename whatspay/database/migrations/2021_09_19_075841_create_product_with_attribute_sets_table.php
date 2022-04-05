<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductWithAttributeSetsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_with_attribute_sets', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->bigInteger('attribute_set_id')->unsigned()->index('p_witp_with_attr_set_attribute_set_id_index')->comment('Belongs to product_attribute_sets');
            $table->bigInteger('product_id')->unsigned()->index('p_with_attr_product_id_index')->comment('Belongs to products table of parent product');
            $table->tinyInteger('order')->default(0);
            $table->foreign('attribute_set_id')
                ->references('id')
                ->on('product_attribute_sets')
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
        Schema::dropIfExists('product_with_attribute_sets');
        Schema::table('product_with_attribute_sets', function (Blueprint $table): void {
            $table->dropSoftDeletes();
        });
    }
}
