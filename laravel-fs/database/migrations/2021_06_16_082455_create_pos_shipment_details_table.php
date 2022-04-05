<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosShipmentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pos_shipment_details', function (Blueprint $table): void {
            $table->id();

            $table->boolean('recived')->nullable();
            $table->unsignedBigInteger('pos_shipments_id');
            $table->unsignedBigInteger('pos_boxes_id');

            $table->foreign('pos_shipments_id')->references('id')->on('pos_shipments');
            $table->foreign('pos_boxes_id')->references('id')->on('pos_boxes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pos_shipment_details');
    }
}
