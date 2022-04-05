<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCmsPagesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cms_pages', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->string('name');
            $table->longText('short_description');
            $table->longText('description');
            $table->string('slug');
            $table->string('image')->nullable();
            $table->string('meta_title');
            $table->string('meta_keyword');
            $table->string('meta_content');
            $table->tinyInteger('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cms_pages');
    }
}
