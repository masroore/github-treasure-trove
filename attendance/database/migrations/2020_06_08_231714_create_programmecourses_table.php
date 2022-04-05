<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgrammecoursesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('programmecourses', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('programme')->nullable();
            $table->string('progcode')->nullable();
            $table->string('semester')->nullable();
            $table->string('level')->nullable();
            $table->string('coursetitle')->nullable();
            $table->string('coursecode')->nullable();
            $table->string('credithours')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programmecourses');
    }
}
