<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimetablegroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timetablegroups', function (Blueprint $table) {
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
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('timetablegroups');
    }
}
