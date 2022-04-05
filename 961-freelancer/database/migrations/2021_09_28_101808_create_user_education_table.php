<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserEducationTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_education', function (Blueprint $table): void {
            $table->id();
            $table->integer('user_id');
            $table->string('institute');
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->string('continue_study')->nullable();
            $table->string('degree')->nullable();
            $table->string('area_of_study')->nullable();
            $table->longText('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_education');
    }
}
