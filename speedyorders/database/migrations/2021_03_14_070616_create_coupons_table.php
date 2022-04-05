<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table): void {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->string('code')->default(null)->nullable();
            $table->string('type')->default('percentage')->nullable();
            $table->integer('amount')->default(0)->nullable();
            $table->integer('max_limit')->default(null)->nullable();
            $table->integer('limit_per_user')->default(0)->nullable();
            $table->integer('min_order_amount')->default(0)->nullable();
            $table->string('start_date')->default(null)->nullable();
            $table->string('expiry_date')->default(null)->nullable();
            $table->string('status')->default('1')->comment('1=>Active,0=>Inactive')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
}
