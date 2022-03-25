<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSemesterfeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('semesterfees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('level');
            $table->string('session');
            $table->string('fee');
            $table->string('feecode');
            $table->string('feeamount');
            $table->string('academicyear');
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
        Schema::dropIfExists('semesterfees');
    }
}
