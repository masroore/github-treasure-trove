<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_cart', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('php_session_id', 255)->default(null)->nullable();
            $table->integer('product_id')->default(null)->nullable();
            $table->integer('quantity')->default(null)->nullable();
            $table->string('unit_price')->default(null)->nullable();
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
        Schema::dropIfExists('temp_cart');
    }
}
