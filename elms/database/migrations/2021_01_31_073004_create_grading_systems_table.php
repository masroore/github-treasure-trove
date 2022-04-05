<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradingSystemsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('grading_systems', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('section_id')->onDelete('cascade')->constrained();
            $table->integer('attendance_weight')->default(5);
            $table->integer('assignment_weight')->default(15);
            $table->integer('quiz_weight')->default(15);
            $table->integer('activity_weight')->default(15);
            $table->integer('exam_weight')->default(50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grading_systems');
    }
}
