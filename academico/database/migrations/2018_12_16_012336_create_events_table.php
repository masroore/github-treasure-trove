<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table): void {
            $table->increments('id');
            $table->integer('course_id')->nullable()->unsigned(); //! Events should be related to coursetime only.
            $table->integer('teacher_id')->nullable()->unsigned();
            $table->integer('room_id')->nullable()->unsigned();
            $table->datetime('start');
            $table->datetime('end');
            $table->string('name');
            $table->integer('course_time_id')->nullable()->unsigned();
            $table->boolean('exempt_attendance')->nullable();
            //$table->softDeletes();
            $table->timestamps();
        });

        Schema::table('events', function (Blueprint $table): void {
            $table->foreign('course_id')
                ->references('id')->on('courses')
                ->onDelete('cascade');

            $table->foreign('room_id')
                ->references('id')->on('rooms')
                ->onDelete('restrict');

            $table->foreign('course_time_id')
                ->references('id')->on('course_times')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('events');
    }
}
