<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogCategory extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('blog_category', function (Blueprint $table): void {
            $table->increments('id');
            $table->unsignedInteger('blog_id');
            $table->unsignedInteger('category_id');
            $table->timestamps();

            $table->foreign('blog_id')
                ->references('id')->on('blog')
                ->onDelete('cascade');

            $table->foreign('category_id')
                ->references('id')->on('category')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_category');
    }
}
