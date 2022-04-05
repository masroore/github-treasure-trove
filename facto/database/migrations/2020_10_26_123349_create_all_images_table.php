<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllImagesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('all_images', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->string('type')->nullable();
            $table->unsignedBigInteger('all_imagable_id');
            $table->string('all_imagable_type');
            $table->string('thumb_path')->nullable();
            $table->string('org_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('all_images');
    }
}
