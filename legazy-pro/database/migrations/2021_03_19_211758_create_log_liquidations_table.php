<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogLiquidationsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('log_liquidations', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->bigInteger('idliquidation')->unsigned();
            $table->foreign('idliquidation')->references('id')->on('liquidactions')->onUpdate('cascade')->onDelete('cascade');
            $table->string('comentario')->nullable();
            $table->string('accion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_liquidations');
    }
}
