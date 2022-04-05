<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('coupon_histories', function (Blueprint $table): void {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('coupon_id')->default(null)->nullable();
            $table->unsignedBigInteger('order_id')->default(null)->nullable();
            $table->unsignedBigInteger('customer_id')->default(null)->nullable();
            $table->string('coupon_code')->default(null)->nullable();
            $table->integer('order_amount')->default(0)->nullable();
            $table->string('status')->default('1')->comment('1=>Used,2=>Reverted,3=>Cancelled')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupon_histories');
    }
}
