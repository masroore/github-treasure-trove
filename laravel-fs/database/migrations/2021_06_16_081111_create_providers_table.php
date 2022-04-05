<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvidersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('providers', function (Blueprint $table): void {
            $table->id();
            $table->string('rif', 20);
            $table->string('name_provider', 50);
            $table->string('phone', 7);
            $table->string('email', 50);
            $table->string('contact_person', 200);
            $table->string('position_person', 200);
            $table->boolean('status')->default(false);

            $table->unsignedBigInteger('telephone_operator_id');
            $table->unsignedBigInteger('state_id');
            $table->unsignedBigInteger('municipalitie_id');
            $table->unsignedBigInteger('city_id');

            $table->unsignedBigInteger('user_id');
            $table->timestamp('date_register')->nullable();
            $table->string('ip', 20);

            $table->foreign('telephone_operator_id')->references('id')->on('telephone_operators');
            $table->foreign('state_id')->references('id')->on('states');
            $table->foreign('municipalitie_id')->references('id')->on('municipalities');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('user_id')->references('id')->on('users');
        });
        DB::table('providers')->insert([
            [
                'rif' => '555555',
                'name_provider' => 'PROVEEDOR PRUEBA',
                'phone' => '1234567',
                'email' => 'prueba@prueba.com',
                'contact_person' => 'laura',
                'position_person' => 'pela gu',
                'status' => 1,
                'telephone_operator_id' => 1,
                'state_id' => 1,
                'municipalitie_id' => 1,
                'city_id' => 1,
                'user_id' => 1,
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('providers');
    }
}
