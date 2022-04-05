<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategorySlidersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('category_sliders')) {
            Schema::create('category_sliders', function (Blueprint $table): void {
                $table->increments('id');
                $table->text('category_ids', 65535)->nullable();
                $table->integer('pro_limit')->unsigned()->nullable();
                $table->integer('status')->unsigned()->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('category_sliders');
    }
}
