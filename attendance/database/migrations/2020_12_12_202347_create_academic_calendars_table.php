<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcademicCalendarsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('academic_calendars', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('startdate')->nullable();
            $table->string('enddate')->nullable();
            $table->string('border')->nullable();
            $table->string('background')->nullable();
            $table->string('semester')->nullable();
            $table->string('academicyear')->nullable();
            $table->string('coursecode')->nullable();
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
        Schema::dropIfExists('academic_calendars');
    }
}
