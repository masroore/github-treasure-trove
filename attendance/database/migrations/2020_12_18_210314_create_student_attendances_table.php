<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('student_attendances', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('indexnumber')->nullable();
            $table->string('attendance')->nullable();
            $table->string('note')->nullable();
            $table->string('year')->nullable();
            $table->string('month')->nullable();
            $table->string('day')->nullable();
            $table->string('date')->nullable();
            $table->string('semester')->nullable();
            $table->string('academicyear')->nullable();
            $table->string('coursecode')->nullable();
            $table->string('session')->nullable();
            $table->string('lectid')->nullable();
            $table->string('lecname')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_attendances');
    }
}
