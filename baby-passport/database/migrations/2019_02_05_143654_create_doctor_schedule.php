<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorSchedule extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('doctor_schedule', function (Blueprint $table): void {
            $table->increments('id');
            $table->unsignedInteger('doctor_id');
            $table->unsignedInteger('pacient_id');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->text('comment')->nullable();
            $table->timestamps();

            $table->foreign('doctor_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('pacient_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_schedule');
    }
}
