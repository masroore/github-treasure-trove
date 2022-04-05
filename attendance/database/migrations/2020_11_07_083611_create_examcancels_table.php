<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamcancelsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('examcancels', function (Blueprint $table): void {
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
     */
    public function down(): void
    {
        Schema::dropIfExists('examcancels');
    }
}
