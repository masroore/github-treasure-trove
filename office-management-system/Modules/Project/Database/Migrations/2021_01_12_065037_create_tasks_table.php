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

            $table->uuid('uuid')->nullable();

            $table->foreignId('project_id')->nullable()->comment('on delete cascade');
            $table->foreign('project_id')->on('projects')->references('id')->onDelete('cascade');

            $table->foreignId('section_id')->nullable()->comment('on delete set null');
            $table->foreign('section_id')->on('sections')->references('id')->onDelete('set null');

            $table->foreignId('parent_id')->nullable()->comment('on dDelete set cascade');
            $table->foreign('parent_id')->on('tasks')->references('id')->onDelete('cascade');

            $table->text('name')->nullable();
            $table->boolean('completed')->default(false)->comment('1 => completed, 0 => uncompleted');

            $table->longText('description')->nullable();

            $table->unsignedSmallInteger('order')->default(0);

            $table->foreignId('created_by')->nullable()->comment('on delete set null');
            $table->foreign('created_by')->on('users')->references('id')->onDelete('set null');

            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table): void {
            $table->dropForeign('tasks_project_id_foreign');
            $table->dropForeign('tasks_section_id_foreign');
            $table->dropForeign('tasks_completed_by_foreign');
            $table->dropForeign('tasks_incompleted_by_foreign');
            $table->dropForeign('tasks_parent_id_foreign');
        });
        Schema::dropIfExists('tasks');
    }
}
