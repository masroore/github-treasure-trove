<?php

use deepskylog\AstronomyLibrary\Imports\DeltaTImport;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;

class CreateDeltaTTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(
            'delta_t',
            function (Blueprint $table): void {
                $table->integer('year');
                $table->float('deltat');
            }
        );

        Excel::import(new DeltaTImport(), 'database/deltat.csv');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delta_t');
    }
}
