<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseoverviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courseoverviews', function (Blueprint $table) {
            $table->increments('id');
            $table->string('overview');
            $table->string('objectives');
            $table->string('academicyear');
            $table->string('semester');
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
        Schema::dropIfExists('courseoverviews');
    }
}
