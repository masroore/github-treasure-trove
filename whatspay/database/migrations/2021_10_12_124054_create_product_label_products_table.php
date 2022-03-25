<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductLabelProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_label_products', function (Blueprint $table) {
            $table->bigInteger('product_id')->unsigned()->index('p_label_product_id_index')->comment('Belongs to product');
            $table->bigInteger('product_label_id')->unsigned()->index('p_label_product_label_id_index')->comment('Belongs to product_labels');
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreign('product_label_id')
                ->references('id')
                ->on('product_labels')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_label_products');
    }
}
