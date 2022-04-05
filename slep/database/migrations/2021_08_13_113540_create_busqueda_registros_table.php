<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusquedaRegistrosTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('busqueda_registros', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->string('twitter')->default('Pendiente');
            $table->string('youtube')->default('Pendiente');
            $table->string('google')->default('Pendiente');
            $table->string('facebook')->default('Pendiente');
            $table->string('instagram')->default('Pendiente');
            //Definicion de clave foranea de una busqueda
            $table->biginteger('busqueda_id')->unsigned();
            $table->foreign('busqueda_id')->references('id')->on('busquedas');
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
        Schema::dropIfExists('busqueda_registros');
    }
}
