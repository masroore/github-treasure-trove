<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->string('course_title')->unique();
            $table->string('course_code')->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
