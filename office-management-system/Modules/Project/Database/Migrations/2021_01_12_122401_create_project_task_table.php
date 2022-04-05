<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectTaskTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('project_task', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('task_id')->nullable()->comment('on Delete Cascade');
            $table->foreign('task_id')->on('tasks')->references('id')->onDelete('cascade');

            $table->foreignId('project_id')->nullable()->comment('on Delete Cascade');
            $table->foreign('project_id')->on('projects')->references('id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_task', function (Blueprint $table): void {
            $table->dropForeign('project_task_task_id_foreign');
            $table->dropForeign('project_task_tag_id_foreign');
        });
        Schema::dropIfExists('project_task');
    }
}
