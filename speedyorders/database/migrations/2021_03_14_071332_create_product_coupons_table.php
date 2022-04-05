<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCouponsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_coupons', function (Blueprint $table): void {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('product_id')->default(null)->nullable();
            $table->unsignedBigInteger('coupon_id')->default(null)->nullable();
            $table->string('status')->default('1')->comment('1=>Active,0=>Inactive')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_coupons');
    }
}
