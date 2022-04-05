<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleablesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('saleables', function (Blueprint $table): void {
            $table->unsignedInteger('sale_id');
            $table->unsignedInteger('model_id');
            $table->string('model_type');

            $table->foreign('sale_id')->references('id')->on('sales')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saleables');
    }
}
