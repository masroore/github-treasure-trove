<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentProfilesTable extends Migration
{
    public function up()
    {
        Schema::create('student_profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('student_name');
            $table->string('matric_number')->unique();
            $table->string('gender')->nullable();
            $table->string('level');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
