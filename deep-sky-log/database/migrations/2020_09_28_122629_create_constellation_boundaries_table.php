<?php

use deepskylog\AstronomyLibrary\Imports\ConstellationBoundariesImport;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;

class CreateConstellationBoundariesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(
            'constellation_boundaries',
            function (Blueprint $table): void {
                $table->string('con0', 3);
                $table->string('con0pos', 1);
                $table->string('con1', 3);
                $table->string('con1pos', 1);
                $table->float('ra0', 8, 6);
                $table->float('decl0', 8, 6);
                $table->float('ra1', 8, 6);
                $table->float('decl1', 8, 6);
            }
        );

        Excel::import(new ConstellationBoundariesImport(), 'database/conlines.csv');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('constellation_boundaries');
    }
}
