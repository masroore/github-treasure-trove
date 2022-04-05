<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonplansTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lessonplans', function (Blueprint $table): void {
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
     */
    public function down(): void
    {
        Schema::dropIfExists('lessonplans');
    }
}
