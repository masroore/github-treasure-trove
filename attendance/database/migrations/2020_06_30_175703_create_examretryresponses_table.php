<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamretryresponsesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('examretryresponses', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('user_id')->nullable();
            $table->string('exam_id')->nullable();
            $table->string('question_id')->nullable();
            $table->string('option_id')->nullable();
            $table->string('answer')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('examretryresponses');
    }
}
