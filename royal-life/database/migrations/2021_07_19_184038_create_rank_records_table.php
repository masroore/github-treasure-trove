<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRankRecordsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rank_records', function (Blueprint $table): void {
            $table->id();
            $table->bigInteger('iduser')->unsigned();
            $table->foreign('iduser')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('rank_actual_id')->unsigned();
            $table->foreign('rank_actual_id')->references('id')->on('ranks')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('rank_previou_id')->unsigned()->nullable();
            $table->foreign('rank_previou_id')->references('id')->on('ranks')->onUpdate('cascade')->onDelete('cascade');
            $table->date('fecha_inicio')->comment('fecha inicial del ranko');
            $table->date('fecha_fin')->nullable()->comment('fecha final del rango');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rank_records');
    }
}
