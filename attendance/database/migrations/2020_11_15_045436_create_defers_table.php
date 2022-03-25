<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDefersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('defers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id');
            $table->string('studentid');
            $table->string('reason');
            $table->string('academic_year');
            $table->string('semester');
            $table->string('dueacademicyear');
            $table->string('duesemester');
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
        Schema::dropIfExists('defers');
    }
}
