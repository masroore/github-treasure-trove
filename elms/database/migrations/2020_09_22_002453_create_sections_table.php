<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sections', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('quarter_id')->default(1)->constrained();
            $table->string('code');
            $table->foreignId('teacher_id')->constrained();
            $table->foreignId('course_id')->constrained();
            $table->string('schedule');
            $table->string('room');
            $table->integer('total_days')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
}
