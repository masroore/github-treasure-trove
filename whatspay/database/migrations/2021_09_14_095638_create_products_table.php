<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('store_id')->unsigned()->index('products_store_id_index');
            $table->string('name', 191)->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(1)->comment('0: Inactive, 1: Active')->index('products_status_index');
            $table->text('images')->nullable();
            $table->string('sku', 255)->nullable();
            $table->double('price', 15, 8)->index('product_price_index');
            $table->tinyInteger('with_storehouse_management')->default(0)->comment('0: Stock is not managing, 1: Stock is managing')->index('products_with_storehouse_management_index');
            $table->integer('quantity')->default(0);
            $table->bigInteger('category_id')->unsigned();
            $table->bigInteger('brand_id')->unsigned();
            $table->tinyInteger('is_variation')->default(0)->comment('0: Parent product, 1: variation product')->index('products_is_variation_index');
            $table->tinyInteger('sale_type')->default(0)->comment('0: sale date is not start and end date, 1: it has sale start and end date');
            $table->double('sale_price', 15, 8);
            $table->date('start_date');
            $table->date('end_date');
            $table->foreign('store_id')
                ->references('id')
                ->on('stores')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreign('brand_id')
                ->references('id')
                ->on('brands')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
        Schema::table('products', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
