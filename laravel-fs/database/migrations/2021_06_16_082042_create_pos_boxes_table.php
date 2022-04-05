<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosBoxesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pos_boxes', function (Blueprint $table): void {
            $table->id();
            $table->string('number_box', 10);
            $table->string('initial_serial', 10);
            $table->string('number_lot', 10);
            $table->boolean('processing')->default(false);

            $table->unsignedBigInteger('model_id');
            $table->unsignedBigInteger('pos_register_id');
            $table->unsignedBigInteger('storage_id');

            $table->foreign('model_id')->references('id')->on('models');
            $table->foreign('pos_register_id')->references('id')->on('pos_registers');
            $table->foreign('storage_id')->references('id')->on('storages');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pos_boxes');
    }
}
