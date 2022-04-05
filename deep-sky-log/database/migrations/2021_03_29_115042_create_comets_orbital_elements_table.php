<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCometsOrbitalElementsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(
            'comets_orbital_elements',
            function (Blueprint $table): void {
                $table->string('name')->primary();
                $table->integer('epoch')->signed();
                $table->float('q', 12, 8);
                $table->float('e', 10, 5);
                $table->float('i', 10, 5);
                $table->float('w', 10, 5);
                $table->float('node', 10, 5);
                $table->float('Tp', 15, 5);
                $table->string('ref');
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comets_orbital_elements');
    }
}
