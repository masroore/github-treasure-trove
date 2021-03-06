<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTestimonialsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('testimonials')) {
            Schema::create('testimonials', function (Blueprint $table): void {
                $table->increments('id');
                $table->string('name', 191)->nullable();
                $table->text('des', 65535)->nullable();
                $table->text('post', 65535)->nullable();
                $table->string('rating', 191)->nullable();
                $table->string('image', 191)->nullable();
                $table->enum('status', ['0', '1']);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('testimonials');
    }
}
