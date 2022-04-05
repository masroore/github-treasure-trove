<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEvalPresetsTables extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('evaluation_type_presets', function (Blueprint $table): void {
            $table->unsignedBigInteger('evaluation_type_id');
            $table->string('presettable_type');
            $table->unsignedBigInteger('presettable_id');
            $table->integer('order')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
}
