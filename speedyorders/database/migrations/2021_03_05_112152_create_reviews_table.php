<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('customer_id')->default(null)->nullable();
            $table->unsignedBigInteger('product_id')->default(null)->nullable();
            $table->unsignedBigInteger('order_item_id')->default(null)->nullable();
            $table->string('author')->default(null)->nullable();
            $table->string('text')->default(null)->nullable();
            $table->float('rating', 13, 2)->default(0)->nullable();
            $table->string('image')->default(null)->nullable();
            $table->string('status')->default('1')->comment('1=>Active,0=>Inactive')->nullable();
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
        Schema::dropIfExists('reviews');
    }
}
