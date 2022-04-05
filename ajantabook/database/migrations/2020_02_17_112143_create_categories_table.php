<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('categories')) {
            Schema::create('categories', function (Blueprint $table): void {
                $table->increments('id');
                $table->string('title', 191)->nullable();
                $table->string('icon', 191)->nullable();
                $table->string('image', 191)->nullable();
                $table->text('description', 65535)->nullable();
                $table->integer('position')->unsigned()->nullable();
                $table->enum('status', ['0', '1']);
                $table->enum('featured', ['0', '1']);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('categories');
    }
}
