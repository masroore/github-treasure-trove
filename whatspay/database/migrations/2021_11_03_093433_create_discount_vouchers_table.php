<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->enum('discount_type', ['fixed_amount', 'percentage']);
            $table->string('discount_value');
            $table->enum('voucher_type', ['entire', 'over', 'category', 'product']);
            $table->integer('min_order')->nullable();
            $table->enum('payment_method', ['cash_on_delivery', 'online_payment', 'all']);
            $table->string('countries');
            $table->enum('limit_type', ['total', 'per_customer', 'unlimited']);
            $table->string('limit_value')->nullable();
            $table->boolean('with_promotion')->default(0);
            $table->enum('created_by', ['admin', 'store'])->default('store');
            $table->boolean('never_expires')->default(0);
            $table->boolean('status')->default(0);
            $table->date('start_date');
            $table->date('end_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->boolean('everytime')->default(0);
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
        Schema::dropIfExists('discount_vouchers');
    }
}
