<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeywordIdeasTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('keyword_ideas', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->json('json_output');
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
        Schema::dropIfExists('keyword_ideas');
    }
}
