<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalinfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personalinfos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('osncode_id')->nullable();
            $table->string('surname')->nullable();
            $table->string('middlename')->nullable();
            $table->string('firstnames')->nullable();
            $table->string('gender')->nullable();
            $table->string('dateofbirth')->nullable();
            $table->string('religion')->nullable();
            $table->string('denomination')->nullable();
            $table->string('placeofbirth')->nullable();
            $table->string('nationality')->nullable();
            $table->string('hometown')->nullable();
            $table->string('region')->nullable();
            $table->string('disability')->nullable();
            $table->string('postcode')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('maritalstutus')->nullable();
            $table->string('profileimg')->nullable();
            $table->string('approve')->default('0');
            $table->string('approved')->default('0');
            $table->string('status')->default('0');
            $table->string('academicyear')->nullable();
            $table->string('year')->nullable();
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
        Schema::dropIfExists('personalinfos');
    }
}
