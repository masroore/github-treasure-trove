<?php

namespace Database\Seeders;

use App\Models\Ranks;
use Illuminate\Database\Seeder;

class RanksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayRank = [

            [
                'id' => '1',
                'name' => 'Business',
                'description' => 'En este punto ya haz creado la base para construir un negocio de talla
              mundial.',
                'points' => '500',
            ],
            [
                'id' => '2',
                'name' => 'Business PRO',
                'description' => 'Los directivos de la compañía te enviarán un mensaje de
              reconocimiento por la consecución de este gran logro.',
                'points' => '10000',
            ],
            [
                'id' => '3',
                'name' => 'SHARK',
                'description' => 'La compañía te ayudará a seguir creciendo y te desarrollará la marca
              personal para que continúes creciendo en esta industria.',
                'points' => '50000',
            ],
            [
                'id' => '4',
                'name' => 'SHARK PRO',
                'description' => 'La compañía te obsequiará un lujoso anillo y a partir de este
              momento serás parte del prestigioso SHARKS CLUB.',
                'points' => '100000',
            ],
            [
                'id' => '5',
                'name' => 'SHARK ELITE',
                'description' => 'La compañía te premiará con un viaje a Cancún.',
                'points' => '200000',
            ],
            [
                'id' => '6',
                'name' => 'SHARK BLUE',
                'description' => 'La compañía te obsequiará un Apple Kit.',
                'points' => '500000',
            ],
            [
                'id' => '7',
                'name' => 'SHARK BLACK',
                'description' => 'La compañía te llevará a Dubai a conocer nuestras oficinas.',
                'points' => '1200000',
            ],
            [
                'id' => '8',
                'name' => 'SHARK WHITE',
                'description' => 'La compañía te premiará con un lujoso y exclusivo mercedes Benz.',
                'points' => '3000000',
            ],
            [
                'id' => '9',
                'name' => 'SHARK VIP',
                'description' => 'En este punto haz cambiado tu vida y la de miles de personas más,
              seguramente estas experimentando aventuras y sensaciones que
              jamás pensaste vivenciar y en reconocimiento a tu excelente trabajo
              y dedicación la compañía te premiara con un Lamborghini.',
                'points' => '10000000',
            ],
        ];
        foreach ($arrayRank as $rank) {
            Ranks::create($rank);
        }
    }
}
