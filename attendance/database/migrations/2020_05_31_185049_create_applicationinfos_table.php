<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationinfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applicationinfos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('osncode_id')->nullable();
            $table->string('entrylevel')->nullable();
            $table->string('session')->nullable();
            $table->string('firstchoice')->nullable();
            $table->string('secondchoice')->nullable();
            $table->string('thirdchoice')->nullable();
            $table->string('programme')->nullable();
            $table->string('type')->nullable();
            $table->string('duration')->nullable();
            $table->string('indexnumber')->nullable();
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
        Schema::dropIfExists('applicationinfos');
    }
}
