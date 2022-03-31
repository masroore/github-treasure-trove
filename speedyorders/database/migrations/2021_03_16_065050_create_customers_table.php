<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->string('first_name')->default(null)->nullable();
            $table->string('last_name')->default(null)->nullable();
            $table->string('email')->unique()->default(null)->nullable();
            $table->string('telephone')->unique()->default(null)->nullable();
            $table->string('newsletter')->default('0')->comment('1=>Enabled,0=>Disabled')->nullable();
            $table->string('safe')->default('1')->comment('1=>Yes,0=>No')->nullable();
            $table->string('status')->default('1')->comment('1=>Active,0=>Inactive')->nullable();
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
        Schema::dropIfExists('customers');
    }
}
