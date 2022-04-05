<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorProfile extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('doctor_profile', function (Blueprint $table): void {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('hospital_id')->nullable();
            $table->unsignedInteger('rating_id');
            $table->string('photo')->nullable();
            $table->string('address');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('appointment_duration');
            $table->text('about_me');

            $table->primary('user_id');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('hospital_id')
                ->references('id')->on('hospital')
                ->onDelete('cascade');

            $table->foreign('rating_id')
                ->references('id')->on('hospital')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_profile');
    }
}
