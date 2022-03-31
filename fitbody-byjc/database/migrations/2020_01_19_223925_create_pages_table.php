<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('category_id')->unsigned();
            $table->string('name')->index();
            $table->string('slug');
            $table->text('description')->nullable();
            $table->string('seo_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('image')->nullable();
            $table->string('group')->nullable();
            $table->integer('viewed')->unsigned()->default(0);
            $table->timestamp('publish_date')->nullable();
            $table->string('lang')->default('hr');
            $table->boolean('status')->default(false);
            $table->timestamps();
        });

        Schema::create('page_block', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('page_id')->unsigned();
            $table->string('type');
            $table->string('path')->nullable();
            $table->string('thumb')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('group')->nullable();
            $table->integer('sort_order')->unsigned();
            $table->timestamps();
        });

        Schema::create('page_tag', function (Blueprint $table) {
            $table->integer('page_id')->unsigned();
            $table->integer('tag_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
        Schema::dropIfExists('page_tag');
    }
}
