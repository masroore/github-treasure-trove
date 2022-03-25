<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonplansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessonplans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('week');
            $table->string('topic');
            $table->string('aims');
            $table->string('obj');
            $table->string('skills');
            $table->string('materials');
            $table->string('questions');
            $table->string('feedback');
            $table->string('semester');
            $table->string('academicyear');
            $table->string('user_id');
            $table->string('course_code');
            $table->string('fullname');
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
        Schema::dropIfExists('lessonplans');
    }
}
