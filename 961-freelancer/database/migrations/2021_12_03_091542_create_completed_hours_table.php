<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompletedHoursTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('completed_hours', function (Blueprint $table): void {
            $table->id();
            $table->string('job_id');
            $table->integer('proposal_id');
            $table->string('hourly_amount');
            $table->string('completed_hours');
            $table->string('weekly_payment');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('completed_hours');
    }
}
