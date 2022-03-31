<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('trans_id');
            $table->integer('user_id');
            $table->integer('token');
            $table->float('gross_amt');
            $table->float('fee_amt');
            $table->float('net_amt');
            $table->string('payer_id');
            $table->string('email');
            $table->string('currency_code');
            $table->string('country_code');
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('transactions');
    }
}
