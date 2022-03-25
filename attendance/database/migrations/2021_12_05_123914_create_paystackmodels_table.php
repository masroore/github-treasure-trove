<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaystackmodelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paystackmodels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tid')->nullable();
            $table->string('tistatus')->nullable();
            $table->string('reference')->nullable();
            $table->string('indexnumber')->nullable();
            $table->string('amount')->nullable();
            $table->string('message')->nullable();
            $table->string('reponse')->nullable();
            $table->string('paymentdate')->nullable();
            $table->string('channel')->nullable();
            $table->string('currency')->nullable();
            $table->string('ipaddress')->nullable();
            $table->string('feecharge')->nullable();
            $table->string('authcode')->nullable();
            $table->string('cardtype')->nullable();
            $table->string('bank')->nullable();
            $table->string('countrycode')->nullable();
            $table->string('brand')->nullable();
            $table->string('first4')->nullable();
            $table->string('last4')->nullable();
            $table->string('customercode')->nullable();
            $table->string('customeremail')->nullable();
            $table->string('logstarttime')->nullable();
            $table->string('logspenttime')->nullable();
            $table->string('logattempts')->nullable();
            $table->string('logerrors')->nullable();
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
        Schema::dropIfExists('paystackmodels');
    }
}
