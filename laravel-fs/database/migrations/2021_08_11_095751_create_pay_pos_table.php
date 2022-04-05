<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayPosTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pay_pos', function (Blueprint $table): void {
            $table->id();
            $table->string('reference', 20);
            $table->string('amount', 20);
            $table->string('number_account', 20);
            $table->timestamp('date_pay')->nullable();
            $table->unsignedBigInteger('client_pos_id');
            $table->unsignedBigInteger('pay_method_id');

            $table->unsignedBigInteger('user_id');
            $table->timestamp('register_date')->nullable();
            $table->string('ip', 20);

            $table->foreign('client_pos_id')->references('id')->on('client_pos');
            $table->foreign('pay_method_id')->references('id')->on('pay_methods');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pay_pos');
    }
}
