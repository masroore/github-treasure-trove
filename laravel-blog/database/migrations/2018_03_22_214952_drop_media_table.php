<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropMediaTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table): void {
            $table->dropForeign(['thumbnail_id']);
            $table->dropColumn('thumbnail_id');
        });

        Schema::dropIfExists('media');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('media', function (Blueprint $table): void {
            $table->increments('id');

            $table->string('filename');
            $table->string('original_filename');
            $table->string('mime_type');
            $table->nullableMorphs('mediable');

            $table->timestamps();
        });

        Schema::table('posts', function (Blueprint $table): void {
            $table->integer('thumbnail_id')->unsigned()->nullable();
            $table->foreign('thumbnail_id')->references('id')->on('media');
        });
    }
}
