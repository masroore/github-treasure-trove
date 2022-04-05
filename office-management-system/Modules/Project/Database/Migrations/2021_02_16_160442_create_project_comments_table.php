<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectCommentsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('project_comments', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('project_id')->nullable();
            $table->foreign('project_id')->on('projects')->references('id')->onDelete('cascade');

            $table->foreignId('parent_id')->nullable();
            $table->foreign('parent_id')->on('project_comments')->references('id')->onDelete('cascade');

            $table->foreignId('created_by')->nullable();
            $table->foreign('created_by')->on('users')->references('id')->onDelete('cascade');

            $table->longText('comment')->nullable();

            $table->boolean('pin_top')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_comments');
    }
}
