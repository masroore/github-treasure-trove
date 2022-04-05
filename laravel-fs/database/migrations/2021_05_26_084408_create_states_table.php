<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('states', function (Blueprint $table): void {
            $table->id();
            $table->string('name_state', 50);

            $table->unsignedBigInteger('country_id');

            $table->unsignedBigInteger('user_id');
            $table->timestamp('date_register')->nullable();
            $table->string('ip', 20);

            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('user_id')->references('id')->on('users');
        });

        DB::table('states')->insert([
            [
                'name_state' => 'Amazonas',
                'country_id' => '1',
                'user_id' => '1',
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_state' => 'Anzoátegui',
                'country_id' => '1',
                'user_id' => '1',
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_state' => 'Apure',
                'country_id' => '1',
                'user_id' => '1',
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_state' => 'Aragua',
                'country_id' => '1',
                'user_id' => '1',
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_state' => 'Barinas',
                'country_id' => '1',
                'user_id' => '1',
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_state' => 'Bolívar',
                'country_id' => '1',
                'user_id' => '1',
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_state' => 'Carabobo',
                'country_id' => '1',
                'user_id' => '1',
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_state' => 'Cojedes',
                'country_id' => '1',
                'user_id' => '1',
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_state' => 'Delta Amacuro',
                'country_id' => '1',
                'user_id' => '1',
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_state' => 'Falcón',
                'country_id' => '1',
                'user_id' => '1',
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_state' => 'Guárico',
                'country_id' => '1',
                'user_id' => '1',
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_state' => 'Lara',
                'country_id' => '1',
                'user_id' => '1',
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_state' => 'Mérida',
                'country_id' => '1',
                'user_id' => '1',
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_state' => 'Miranda',
                'country_id' => '1',
                'user_id' => '1',
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_state' => 'Monagas',
                'country_id' => '1',
                'user_id' => '1',
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_state' => 'Nueva Esparta',
                'country_id' => '1',
                'user_id' => '1',
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_state' => 'Portuguesa',
                'country_id' => '1',
                'user_id' => '1',
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_state' => 'Sucre',
                'country_id' => '1',
                'user_id' => '1',
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_state' => 'Táchira',
                'country_id' => '1',
                'user_id' => '1',
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_state' => 'Trujillo',
                'country_id' => '1',
                'user_id' => '1',
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_state' => 'La Guaira',
                'country_id' => '1',
                'user_id' => '1',
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_state' => 'Yaracuy',
                'country_id' => '1',
                'user_id' => '1',
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_state' => 'Zulia',
                'country_id' => '1',
                'user_id' => '1',
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_state' => 'Distrito Capital',
                'country_id' => '1',
                'user_id' => '1',
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_state' => 'Dependencias Federales',
                'country_id' => '1',
                'user_id' => '1',
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
        Schema::dropIfExists('states');
    }
}
