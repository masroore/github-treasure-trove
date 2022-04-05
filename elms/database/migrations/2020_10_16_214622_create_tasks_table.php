<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('quarter_id')->default(1)->constrained();
            $table->boolean('open')->default(true);
            $table->dateTime('open_on')->nullable()->default(null);
            $table->foreignId('module_id')->constrained();
            $table->foreignId('section_id')->constrained();
            $table->foreignId('teacher_id')->constrained();
            $table->foreignId('task_type_id')->constrained();
            $table->string('name');
            $table->mediumText('instructions')->nullable()->default(null);
            $table->integer('max_score');
            $table->text('essay_rubric')->nullable()->default(null);
            $table->longText('content');
            $table->dateTime('deadline')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
}
