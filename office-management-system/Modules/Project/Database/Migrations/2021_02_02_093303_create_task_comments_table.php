<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskCommentsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('task_comments', function (Blueprint $table): void {
            $table->id();
            $table->string('event')->nullable();

            $table->foreignId('field_id')->nullable();
            $table->foreign('field_id')->on('fields')->references('id')->onDelete('cascade');

            $table->foreignId('task_id')->nullable();
            $table->foreign('task_id')->on('tasks')->references('id')->onDelete('cascade');

            $table->unsignedBigInteger('old_id')->nullable();
            $table->unsignedBigInteger('new_id')->nullable();
            $table->string('table_type', 255)->nullable();

            $table->foreignId('created_by')->nullable();
            $table->foreign('created_by')->on('users')->references('id')->onDelete('cascade');

            $table->longText('comment')->nullable();
            $table->longText('old_value')->nullable();

            $table->boolean('pin_top')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_comments');
    }
}
