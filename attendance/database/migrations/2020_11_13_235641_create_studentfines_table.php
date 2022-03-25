<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentfinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('studentfines', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id');
            $table->string('studentfeeid');
            $table->string('fine');
            $table->string('feecode');
            $table->string('amount');
            $table->string('studendid');
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
        Schema::dropIfExists('studentfines');
    }
}
