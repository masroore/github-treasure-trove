<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosRequestDetailsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pos_request_details', function (Blueprint $table): void {
            $table->id();
            $table->string('quantity', 20);

            $table->unsignedBigInteger('pos_request_id');
            $table->unsignedBigInteger('model_id');

            $table->foreign('pos_request_id')->references('id')->on('pos_requests');
            $table->foreign('model_id')->references('id')->on('models');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pos_request_details');
    }
}
