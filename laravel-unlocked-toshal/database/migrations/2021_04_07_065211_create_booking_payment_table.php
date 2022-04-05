<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingPaymentTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('booking_payments', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->integer('booking_id');
            $table->integer('user_id');
            $table->string('user_cookie_id');
            $table->string('trans_id');
            $table->double('price', 8, 2);
            $table->double('commission', 8, 2);
            $table->double('payable_amount', 8, 2);
            $table->string('trans_status');
            $table->tinyInteger('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_payments');
    }
}
