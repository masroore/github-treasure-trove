<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubcategoriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('subcategories')) {
            Schema::create('subcategories', function (Blueprint $table): void {
                $table->increments('id');
                $table->string('title', 191)->nullable();
                $table->string('icon', 191)->nullable();
                $table->string('image', 191)->nullable();
                $table->text('description', 65535)->nullable();
                $table->integer('parent_cat')->unsigned();
                $table->integer('position')->unsigned()->nullable();
                $table->integer('status');
                $table->integer('featured');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('subcategories');
    }
}
