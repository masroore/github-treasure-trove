<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamcancelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('examcancels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('course_id')->nullable();
            $table->string('IA_mark')->nullable();
            $table->string('exams_mark')->nullable();
            $table->string('total_marks')->nullable();
            $table->string('grade')->nullable();
            $table->string('grade_point')->nullable();
            $table->string('total_gp')->nullable();
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
        Schema::dropIfExists('examcancels');
    }
}
