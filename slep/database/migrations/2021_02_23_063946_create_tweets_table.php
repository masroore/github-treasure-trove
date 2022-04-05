<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTweetsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tweets', function (Blueprint $table): void {
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

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tweets');
    }
}
