<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCoursesTable extends Migration
{
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->unsignedBigInteger('course_lecturer_id');
            $table->foreign('course_lecturer_id', 'course_lecturer_fk_5390396')->references('id')->on('users');
            $table->unsignedBigInteger('department_id');
            $table->foreign('department_id', 'department_fk_5390446')->references('id')->on('departments');
        });
    }
}
