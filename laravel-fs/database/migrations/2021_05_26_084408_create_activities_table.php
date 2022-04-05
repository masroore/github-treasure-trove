<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table): void {
            $table->id();
            $table->string('name_activity', 60);
            $table->boolean('status')->default(true);

            $table->unsignedBigInteger('user_id');
            $table->timestamp('date_register')->nullable();
            $table->string('ip', 20);

            $table->foreign('user_id')->references('id')->on('users');
        });
        DB::table('activities')->insert([
            [
                'name_activity' => 'AEROLINEAS, TRANSPORTE TERRESTE, TRANSPORTE ACUATICO',
                'status' => '1',
                'user_id' => '1',
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_activity' => 'AGRICULTURA, GANADERIA, AVICULTURA',
                'status' => '1',
                'user_id' => '1',
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_activity' => 'BANCA, FINANZAS Y SEGUROS',
                'status' => '1',
                'user_id' => '1',
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_activity' => 'CLUBES, ASOCIACIONES',
                'status' => '1',
                'user_id' => '1',
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_activity' => 'COMERCIOS',
                'status' => '1',
                'user_id' => '1',
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_activity' => 'EDUCACION, ESCUELAS, LIBRERIAS',
                'status' => '1',
                'user_id' => '1',
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_activity' => 'ENTRETENIMIENTO',
                'status' => '1',
                'user_id' => '1',
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_activity' => 'HIDROCARBUROS',
                'status' => '1',
                'user_id' => '1',
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_activity' => 'HOTELES Y POSADAS',
                'status' => '1',
                'user_id' => '1',
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_activity' => 'JUEGOS DE AZAR, APUESTAS, VIDEO JUEGOS',
                'status' => '1',
                'user_id' => '1',
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_activity' => 'LICORERIAS, TASCAS, EXPENDIO DE LICORES',
                'status' => '1',
                'user_id' => '1',
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_activity' => 'LOCALES COMERCIALES, COMERCIOS, E-COMMERCE',
                'status' => '1',
                'user_id' => '1',
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_activity' => 'MISCELANEOS',
                'status' => '1',
                'user_id' => '1',
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_activity' => 'ORGANIZACIONES',
                'status' => '1',
                'user_id' => '1',
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_activity' => 'RESTAURANTES',
                'status' => '1',
                'user_id' => '1',
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_activity' => 'SERVICIOS GENERALES',
                'status' => '1',
                'user_id' => '1',
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_activity' => 'SUMINISTROS',
                'status' => '1',
                'user_id' => '1',
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_activity' => 'TELECOMUNICACIONES, REDES ',
                'status' => '1',
                'user_id' => '1',
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_activity' => 'VIVIENDAS',
                'status' => '1',
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
        Schema::dropIfExists('activities');
    }
}
