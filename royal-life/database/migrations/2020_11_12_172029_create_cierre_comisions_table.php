+<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCierreComisionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Schema::create('cierre_comisions', function (Blueprint $table) {
        //     $table->id();
        //     // $table->bigInteger('group_id')->unsigned();
        //     // $table->foreign('group_id')->references('id')->on('groups');
        //     $table->bigInteger('package_id')->unsigned();
        //     $table->foreign('package_id')->references('id')->on('packages')->onUpdate('cascade')->onDelete('cascade');
        //     $table->double('s_inicial')->comment('saldo inicial');
        //     $table->double('s_ingreso')->comment('saldo ingreso');
        //     $table->double('s_final')->comment('saldo final');
        //     $table->date('cierre')->comment('fecha del cierre');
        //     $table->text('comentario')->nullable();
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cierre_comisions');
    }
}
