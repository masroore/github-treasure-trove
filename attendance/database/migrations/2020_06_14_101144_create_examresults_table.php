<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamresultsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('examresults', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('user_id');
            $table->string('semester');
            $table->string('year');
            $table->string('totalgp');
            $table->string('credithours');
            $table->string('gpa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('examresults');
    }
}
