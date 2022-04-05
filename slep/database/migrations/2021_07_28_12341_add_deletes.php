<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeletes extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('deleted_tweets', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->string('id_tweet');
            $table->text('tweet');
            $table->integer('rt');
            $table->integer('fav');
            $table->string('url_imagen');
            $table->string('geo');
            $table->string('usuario');
            $table->integer('followers');
            $table->dateTime('fecha_creacion', 0);

            //Definicion de clave foranea de una busqueda
            $table->biginteger('busqueda_id')->unsigned();
            $table->foreign('busqueda_id')->references('id')->on('busquedas');
            $table->string('tags')->default('');

            $table->timestamps();
        });
        Schema::create('deleted_youtube_videos', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->string('id_video');
            $table->text('description');
            $table->integer('views');
            $table->integer('likes');
            $table->string('url_imagen');
            $table->string('channel_name');
            $table->integer('channel_subs');
            $table->dateTime('upload_date', 0);

            //Definicion de clave foranea de una busqueda
            $table->biginteger('busqueda_id')->unsigned();
            $table->foreign('busqueda_id')->references('id')->on('busquedas');
            $table->string('tags')->default('');

            $table->timestamps();
            $table->string('id_channel')->default('');
        });
        Schema::create('deleted_r_facebook_posts', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->text('url');
            $table->integer('likes');
            $table->integer('comments');
            $table->integer('shares');
            $table->text('message');
            $table->text('image_url');
            $table->dateTime('date', 0);
            $table->integer('followers');
            $table->text('autor_url');
            $table->text('autor');

            //Definicion de clave foranea de una busqueda
            $table->biginteger('busqueda_id')->unsigned();
            $table->foreign('busqueda_id')->references('id')->on('busquedas');
            $table->string('tags')->default('');

            $table->timestamps();
        });
        Schema::create('deleted_google_news_articles', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->text('title');
            $table->text('link');
            $table->dateTime('published_date', 0);
            $table->text('description');
            $table->text('source');

            //Definicion de clave foranea de una busqueda
            $table->biginteger('busqueda_id')->unsigned();
            $table->foreign('busqueda_id')->references('id')->on('busquedas');
            $table->string('tags')->default('');

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
