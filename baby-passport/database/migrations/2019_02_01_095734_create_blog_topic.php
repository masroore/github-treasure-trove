<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogTopic extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('blog_topic', function (Blueprint $table): void {
            $table->increments('id');
            $table->unsignedInteger('blog_id');
            $table->string('title');
            $table->mediumText('content');
            $table->timestamps();

            $table->foreign('blog_id')
                ->references('id')->on('blog')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_topic');
    }
}
