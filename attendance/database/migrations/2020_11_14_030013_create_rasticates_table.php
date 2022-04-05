<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRasticatesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rasticates', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('user_id');
            $table->string('studentid');
            $table->string('reason');
            $table->string('academic_year');
            $table->string('semester');
            $table->string('dueacademicyear');
            $table->string('duesemester');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rasticates');
    }
}
