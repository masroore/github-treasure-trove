<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoogleNewsArticlesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('google_news_articles', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->text('title');
            $table->text('link');
            $table->dateTime('published_date', 0);
            $table->text('description');
            $table->text('source');

            //Definicion de clave foranea de una busqueda
            $table->biginteger('busqueda_id')->unsigned();
            $table->foreign('busqueda_id')->references('id')->on('busquedas');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('google_news_articles');
    }
}
