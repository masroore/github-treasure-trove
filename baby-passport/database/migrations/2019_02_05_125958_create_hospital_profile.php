<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHospitalProfile extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hospital_profile', function (Blueprint $table): void {
            $table->increments('id');
            $table->unsignedInteger('hospital_id');
            $table->string('detail');
            $table->enum('type', ['speciality', 'experience']);

            $table->foreign('hospital_id')
                ->references('id')->on('hospital')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospital_profile');
    }
}
