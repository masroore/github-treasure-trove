<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstrumentTypesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(
            'instrument_types',
            function (Blueprint $table): void {
                $table->integer('id')->primary();
                $table->string('type');
            }
        );

        // Insert the instrument types
        DB::table('instrument_types')->insert(
            [
                'id' => 0,
                'type' => 'Naked Eye',
            ]
        );

        DB::table('instrument_types')->insert(
            [
                'id' => 1,
                'type' => 'Binoculars',
            ]
        );

        DB::table('instrument_types')->insert(
            [
                'id' => 2,
                'type' => 'Refractor',
            ]
        );

        DB::table('instrument_types')->insert(
            [
                'id' => 3,
                'type' => 'Reflector',
            ]
        );

        DB::table('instrument_types')->insert(
            [
                'id' => 4,
                'type' => 'Finderscope',
            ]
        );

        DB::table('instrument_types')->insert(
            [
                'id' => 5,
                'type' => 'Other',
            ]
        );

        DB::table('instrument_types')->insert(
            [
                'id' => 6,
                'type' => 'Cassegrain',
            ]
        );

        DB::table('instrument_types')->insert(
            [
                'id' => 7,
                'type' => 'Kutter',
            ]
        );

        DB::table('instrument_types')->insert(
            [
                'id' => 8,
                'type' => 'Maksutov',
            ]
        );

        DB::table('instrument_types')->insert(
            [
                'id' => 9,
                'type' => 'Schmidt Cassegrain',
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instrument_types');
    }
}
