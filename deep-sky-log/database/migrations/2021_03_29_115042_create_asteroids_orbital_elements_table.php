<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsteroidsOrbitalElementsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(
            'asteroids_orbital_elements',
            function (Blueprint $table): void {
                $table->integer('number');
                $table->string('name');
                $table->integer('epoch')->signed();
                $table->float('a', 12, 8);
                $table->float('e', 12, 8);
                $table->float('i', 10, 5);
                $table->float('w', 10, 5);
                $table->float('node', 10, 5);
                $table->float('M', 15, 7);
                $table->float('H', 5, 2);
                $table->float('G', 5, 2);
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
