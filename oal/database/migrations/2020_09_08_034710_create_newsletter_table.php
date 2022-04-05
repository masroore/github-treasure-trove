<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsletterTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('newsletters', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->text('detail')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('image')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('view_count')->nullable();
            $table->string('slug')->unique();
            $table->integer('active')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('newsletters');
    }
}
