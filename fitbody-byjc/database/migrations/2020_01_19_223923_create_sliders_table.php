<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlidersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('slider_groups', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->string('name')->index();
            $table->integer('blog_id')->unsigned()->nullable();
            $table->integer('page_id')->unsigned()->nullable();
            $table->integer('category_id')->unsigned()->nullable();
            $table->timestamp('date_start')->nullable();
            $table->timestamp('date_end')->nullable();
            $table->integer('clicked')->unsigned()->default(0);
            $table->boolean('status')->default(false);
            $table->timestamps();
        });

        // Atributi proizvoda. Može ih imati više.
        //
        Schema::create('sliders', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->integer('group_id')->unsigned()->nullable();
            $table->string('image')->nullable();
            $table->string('message')->nullable();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('button')->nullable();
            $table->string('url')->nullable();
            $table->string('text_color')->nullable();
            $table->string('text_placement')->nullable();
            $table->integer('sort_order')->unsigned()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slider_groups');
        Schema::dropIfExists('sliders');
    }
}
