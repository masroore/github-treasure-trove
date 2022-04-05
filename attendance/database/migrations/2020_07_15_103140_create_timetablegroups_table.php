<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimetablegroupsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('timetablegroups', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('timetable_id')->nullable();
            $table->string('group');
            $table->string('hall');
            $table->string('lecturer');
            $table->string('lecturer_id');
            $table->string('capacity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timetablegroups');
    }
}
