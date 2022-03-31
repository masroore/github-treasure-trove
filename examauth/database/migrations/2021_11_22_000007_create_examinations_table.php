<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExaminationsTable extends Migration
{
    public function up()
    {
        Schema::create('examinations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('course_id');
            $table->string('status');
            $table->string('student_id');
            $table->string('year')->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
