<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEyepieceTypesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(
            'eyepiece_types',
            function (Blueprint $table): void {
                $table->string('brand', 128);
                $table->string('type', 128);
                $table->timestamps();
                $table->unique(['brand', 'type']);
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eyepiece_types');
    }
}
