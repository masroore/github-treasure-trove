<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddContentToCommentsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('comments');

        Schema::create('comments', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->bigInteger('commentable_id');
            $table->string('commentable_type');
            $table->bigInteger('parent_id')->nullable();
            $table->text('content');
            $table->timestamps();

            $table->index(['commentable_id', 'commentable_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table): void {

        });
    }
}
