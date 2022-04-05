<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGrandcategoriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('grandcategories')) {
            Schema::create('grandcategories', function (Blueprint $table): void {
                $table->increments('id');
                $table->string('title', 191)->nullable();
                $table->string('image', 191)->nullable();
                $table->text('description', 65535)->nullable();
                $table->integer('parent_id')->unsigned()->index('grandcategories_parent_id_foreign');
                $table->integer('subcat_id')->unsigned()->index('grandcategories_subcat_id_foreign');
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
        Schema::drop('grandcategories');
    }
}
