<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConnectionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('connections', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('model_id');
            $table->unsignedBigInteger('connection_mechanisms_id');

            $table->foreign('model_id')->references('id')->on('models');
            $table->foreign('connection_mechanisms_id')->references('id')->on('connection_mechanisms');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('connections');
    }
}
