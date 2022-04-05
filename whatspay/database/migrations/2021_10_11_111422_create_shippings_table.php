<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shippings', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->bigInteger('store_id')->unsigned()->index('shipping_store_id_index')->comment('Belongs to stores table');
            $table->string('title', 100)->default('All');
            $table->string('country', 160)->nullable()->comment('If title is selected All then country name should be NULL');
            $table->foreign('store_id')
                ->references('id')
                ->on('stores')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shippings');
    }
}
