<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLecturersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lecturers', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('user_id')->nullable();
            $table->string('fullname')->nullable();
            $table->string('dateofbirth')->nullable();
            $table->string('address')->nullable();
            $table->string('faculty')->nullable();
            $table->string('gender')->nullable();
            $table->string('religion')->nullable();
            $table->string('qualification')->nullable();
            $table->string('number')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lecturers');
    }
}
