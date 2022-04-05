<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attendance_types', function (Blueprint $table): void {
            $table->increments('id');
            $table->text('name');
        });

        Schema::create('attendances', function (Blueprint $table): void {
            $table->increments('id');
            $table->integer('student_id')->unsigned();
            $table->integer('event_id')->unsigned();
            $table->integer('attendance_type_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('attendances', function (Blueprint $table): void {
            $table->foreign('attendance_type_id')
                ->references('id')->on('attendance_types')
                ->onDelete('restrict');
        });

        Schema::table('attendances', function (Blueprint $table): void {
            $table->foreign('student_id')
                ->references('id')->on('students')
                ->onDelete('cascade');
        });

        Schema::table('attendances', function (Blueprint $table): void {
            $table->foreign('event_id')
                ->references('id')->on('events')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('attendances');
        Schema::dropIfExists('attendance_types');
    }
}
