<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTelephoneOperatorsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('telephone_operators', function (Blueprint $table): void {
            $table->id();
            $table->string('code', 20);
            $table->string('description', 200);

            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('type_operator_id');

            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('type_operator_id')->references('id')->on('type_operators');
        });
        DB::table('telephone_operators')->insert([
            [
                'code' => '414',
                'description' => 'MOVISTAR',
                'country_id' => '1',
                'type_operator_id' => '2',
            ],
            [
                'code' => '424',
                'description' => 'MOVISTAR',
                'country_id' => '1',
                'type_operator_id' => '2',
            ],
            [
                'code' => '416',
                'description' => 'MOVILNET',
                'country_id' => '1',
                'type_operator_id' => '2',
            ],
            [
                'code' => '426',
                'description' => 'MOVILNET',
                'country_id' => '1',
                'type_operator_id' => '2',
            ],
            [
                'code' => '412',
                'description' => 'DIGITEL',
                'country_id' => '1',
                'type_operator_id' => '2',
            ],
            [
                'code' => '248',
                'description' => 'AMAZONAS',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '281',
                'description' => 'ANZOÁTEGUI',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '282',
                'description' => 'ANZOÁTEGUI',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '283',
                'description' => 'ANZOÁTEGUI',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '285',
                'description' => 'ANZOÁTEGUI',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '292',
                'description' => 'ANZOÁTEGUI',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '240',
                'description' => 'APURE',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '247',
                'description' => 'APURE',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '278',
                'description' => 'APURE',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '243',
                'description' => 'ARAGUA',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '244',
                'description' => 'ARAGUA',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '246',
                'description' => 'ARAGUA',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '273',
                'description' => 'BARINAS',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '278',
                'description' => 'BARINAS',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '284',
                'description' => 'BOLÍVAR',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '285',
                'description' => 'BOLÍVAR',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '286',
                'description' => 'BOLÍVAR',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '288',
                'description' => 'BOLÍVAR',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '289',
                'description' => 'BOLÍVAR',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '241',
                'description' => 'CARABOBO',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '242',
                'description' => 'CARABOBO',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '243',
                'description' => 'CARABOBO',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '245',
                'description' => 'CARABOBO',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '249',
                'description' => 'CARABOBO',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '258',
                'description' => 'COJEDES',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '287',
                'description' => 'DELTA AMACURO',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '212',
                'description' => 'DISTRITO CAPITAL',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '259',
                'description' => 'FALCÓN',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '268',
                'description' => 'FALCÓN',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '269',
                'description' => 'FALCÓN',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '279',
                'description' => 'FALCÓN',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '235',
                'description' => 'GUÁRICO',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '238',
                'description' => 'GUÁRICO',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '246',
                'description' => 'GUÁRICO',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '247',
                'description' => 'GUÁRICO',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '251',
                'description' => 'LARA',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '252',
                'description' => 'LARA',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '253',
                'description' => 'LARA',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '271',
                'description' => 'MÉRIDA',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '274',
                'description' => 'MÉRIDA',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '275',
                'description' => 'MÉRIDA',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '212',
                'description' => 'MIRANDA',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '234',
                'description' => 'MIRANDA',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '239',
                'description' => 'MIRANDA',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '287',
                'description' => 'MONAGAS',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '291',
                'description' => 'MONAGAS',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '292',
                'description' => 'MONAGAS',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '295',
                'description' => 'NUEVA ESPARTA',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '255',
                'description' => 'PORTUGUESA',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '256',
                'description' => 'PORTUGUESA',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '257',
                'description' => 'PORTUGUESA',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '272',
                'description' => 'PORTUGUESA',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '293',
                'description' => 'SUCRE',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '294',
                'description' => 'SUCRE',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '275',
                'description' => 'TÁCHIRA',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '276',
                'description' => 'TÁCHIRA',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '277',
                'description' => 'TÁCHIRA',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '278',
                'description' => 'TÁCHIRA',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '271',
                'description' => 'TRUJILLO',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '272',
                'description' => 'TRUJILLO',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '212',
                'description' => 'LA GUAIRA',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '251',
                'description' => 'YARACUY',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '253',
                'description' => 'YARACUY',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '254',
                'description' => 'YARACUY',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '280',
                'description' => 'ZULIA',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '262',
                'description' => 'ZULIA',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '263',
                'description' => 'ZULIA',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '264',
                'description' => 'ZULIA',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '265',
                'description' => 'ZULIA',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '266',
                'description' => 'ZULIA',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '267',
                'description' => 'ZULIA',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '271',
                'description' => 'ZULIA',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],
            [
                'code' => '275',
                'description' => 'ZULIA',
                'country_id' => '1',
                'type_operator_id' => '1',
            ],

        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telephone_operators');
    }
}
