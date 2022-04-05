<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosInventoryKardexesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pos_inventory_kardexes', function (Blueprint $table): void {
            $table->id();
            $table->string('actions', 255);
            $table->unsignedBigInteger('pos_inventory_id');
            $table->timestamp('date_from')->nullable();
            $table->timestamp('date_until')->nullable();

            $table->foreign('pos_inventory_id')->references('id')->on('pos_inventories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pos_inventory_kardexes');
    }
}
