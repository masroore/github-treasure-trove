<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterviewSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(
            'interview_schedules',
            function (Blueprint $table): void {
                $table->id();
                $table->integer('candidate');
                $table->integer('employee')->default(0);
                $table->date('date');
                $table->time('time');
                $table->text('comment')->nullable();
                $table->string('employee_response')->nullable();
                $table->integer('created_by');
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interview_schedules');
    }
}
