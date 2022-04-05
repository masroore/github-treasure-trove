<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientAddressesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('client_addresses', function (Blueprint $table): void {
            $table->id();
            $table->string('edf_qta_tow', 50);
            $table->string('apto_offic_loc_house', 50);
            $table->string('urbanization', 50);
            $table->string('nro_floor', 8);
            $table->string('reference_point', 200);

            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('state_id');
            $table->unsignedBigInteger('municipality_id');
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('postal_code_id');
            $table->unsignedBigInteger('client_id');

            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('state_id')->references('id')->on('states');
            $table->foreign('municipality_id')->references('id')->on('municipalities');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('postal_code_id')->references('id')->on('postal_codes');
            $table->foreign('client_id')->references('id')->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_addresses');
    }
}
