<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideouploadsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('videouploads', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('week');
            $table->string('title');
            $table->string('desc');
            $table->string('url');
            $table->string('youtubeid');
            $table->string('academicyear');
            $table->string('semester');
            $table->string('user_id');
            $table->string('course_code');
            $table->string('fullname');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videouploads');
    }
}
