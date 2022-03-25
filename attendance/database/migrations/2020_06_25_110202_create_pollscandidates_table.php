<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePollscandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pollscandidates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pollstype_id');
            $table->string('indexnumber');
            $table->string('fullname');
            $table->string('position');
            $table->string('user_id');
            $table->string('votes')->default('0');
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
        Schema::dropIfExists('pollscandidates');
    }
}
