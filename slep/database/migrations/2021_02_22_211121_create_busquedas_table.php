<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusquedasTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('busquedas', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->json('json_busqueda');
            $table->json('json_youtube');
            $table->string('nombre_busqueda');
            $table->string('palabra_busqueda');
            $table->date('fecha_inicial_original');
            $table->date('fecha_inicial');
            $table->date('fecha_final');

            //Definicion de clave foranea de una busqueda asociada a una campaña
            $table->biginteger('campania_id')->unsigned();
            $table->foreign('campania_id')->references('id')->on('campanias');

            //Definicion de clave foranea de una busqueda asociada a un usuario
            $table->biginteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('busquedas');
    }
}
