<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeletedRInstagramPostsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('deleted_r_instagram_posts', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->text('url');
            $table->integer('likes');
            $table->integer('comments');
            $table->integer('followers');
            $table->text('autor_total_posts');
            $table->dateTime('date', 0);
            $table->text('message');
            $table->text('autor_url');
            $table->text('autor');
            $table->text('image_url');
            //Definicion de clave foranea de una busqueda
            $table->biginteger('busqueda_id')->unsigned();
            $table->foreign('busqueda_id')->references('id')->on('busquedas');
            $table->string('tags')->default('');
            $table->integer('shares')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('async_results');
    }
}
