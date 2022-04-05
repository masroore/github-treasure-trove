<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIpalKelurahanPivotTable extends Migration
{
    public function up(): void
    {
        Schema::create('ipal_kelurahan', function (Blueprint $table): void {
            $table->unsignedBigInteger('ipal_id');
            $table->foreign('ipal_id', 'ipal_id_fk_5267076')->references('id')->on('ipals')->onDelete('cascade');
            $table->unsignedBigInteger('kelurahan_id');
            $table->foreign('kelurahan_id', 'kelurahan_id_fk_5267076')->references('id')->on('kelurahans')->onDelete('cascade');
        });
    }
}
