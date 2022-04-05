<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartItem extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cart_item', function (Blueprint $table): void {
            $table->increments('id');
            $table->unsignedInteger('cart_id');
            $table->unsignedInteger('hospital_product_id');
            $table->integer('quantity');
            $table->decimal('discount', 10, 2)->nullable();
            $table->decimal('total', 10, 2);

            $table->foreign('cart_id')
                ->references('id')->on('cart')
                ->onDelete('cascade');

            $table->foreign('hospital_product_id')
                ->references('id')->on('hospital_product')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_item');
    }
}
