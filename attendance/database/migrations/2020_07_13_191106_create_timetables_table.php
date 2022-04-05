<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimetablesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('timetables', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('level');
            $table->string('sesson');
            $table->string('programme');
            $table->string('coursecode');
            $table->string('course');
            $table->string('day');
            $table->string('ftime');
            $table->string('ttime');
            $table->string('semester');
            $table->string('academicyear');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timetables');
    }
}
