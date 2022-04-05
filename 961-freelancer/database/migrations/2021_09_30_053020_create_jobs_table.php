<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jobs', function (Blueprint $table): void {
            $table->id();
            $table->integer('user_id');
            $table->string('job_id');
            $table->string('job_title');
            $table->string('service_level');
            $table->string('job_type');
            $table->string('hourly_min_price')->nullable();
            $table->string('hourly_max_price')->nullable();
            $table->string('fixed_price')->nullable();
            $table->string('job_duration');
            $table->integer('is_featured')->nullable();
            $table->longText('job_description');
            $table->longText('job_skills');
            $table->longText('job_cat');
            $table->longText('job_location');
            $table->longText('job_attachement');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
}
