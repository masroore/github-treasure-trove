<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVariantImagesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('variant_images')) {
            Schema::create('variant_images', function (Blueprint $table): void {
                $table->increments('id');
                $table->string('image1', 191)->nullable();
                $table->string('image2', 191)->nullable();
                $table->string('image3', 191)->nullable();
                $table->string('image4', 191)->nullable();
                $table->string('image5', 191)->nullable();
                $table->string('image6', 191)->nullable();
                $table->string('main_image', 191)->nullable();
                $table->integer('var_id')->unsigned()->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('variant_images');
    }
}
