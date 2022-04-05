<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskDependenciesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('task_dependencies', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('task_id')->nullable()->comment('on Delete Cascade');
            $table->foreign('task_id')->on('tasks')->references('id')->onDelete('cascade');

            $table->boolean('direction')->default(false)->comment('0 => blocked by, 1 => blocking');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('task_dependencies', function (Blueprint $table): void {
            $table->dropForeign('task_dependencies_task_id_foreign');
        });
        Schema::dropIfExists('task_dependencies');
    }
}
