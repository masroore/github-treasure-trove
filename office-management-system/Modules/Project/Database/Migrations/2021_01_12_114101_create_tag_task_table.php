<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagTaskTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tag_task', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('task_id')->nullable()->comment('on Delete Cascade');
            $table->foreign('task_id')->on('tasks')->references('id')->onDelete('cascade');

            $table->foreignId('tag_id')->nullable()->comment('on Delete Cascade');
            $table->foreign('tag_id')->on('tags')->references('id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tag_task', function (Blueprint $table): void {
            $table->dropForeign('tag_task_task_id_foreign');
            $table->dropForeign('tag_task_tag_id_foreign');
        });
        Schema::dropIfExists('tag_task');
    }
}
