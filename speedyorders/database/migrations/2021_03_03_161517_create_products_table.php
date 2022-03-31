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
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('category_id')->default(null)->nullable();
            $table->string('sku')->default(null)->nullable();
            $table->string('name')->default(null)->nullable();
            $table->integer('length')->default(0)->nullable();
            $table->integer('breadth')->default(0)->nullable();
            $table->integer('height')->default(0)->nullable();
            $table->integer('width')->default(0)->nullable();
            $table->text('description')->default(null)->nullable();
            $table->float('base_price', 13, 2)->default(0)->nullable();
            $table->integer('quantity')->default(0)->nullable();
            $table->integer('min_quantity')->default(0)->nullable();
            $table->integer('subtract_stock')->default(0)->nullable();
            $table->integer('sort_order')->default(0)->nullable();
            $table->string('status')->default('1')->comment('1=>Active,0=>Inactive')->nullable();
            $table->string('image')->default(null)->nullable();
            $table->string('video')->default(null)->nullable();
            $table->boolean('trending')->default(false)->nullable();
            $table->string('is_featured')->default('0')->comment('1=>Featured,0=>NotFeatured')->nullable();
            $table->string('meta_title')->default(null)->nullable();
            $table->text('meta_description')->default(null)->nullable();
            $table->softDeletes();
            $table->timestamps();
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
    }
}
