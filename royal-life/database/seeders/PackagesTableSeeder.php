<?php

namespace Database\Seeders;

use App\Models\Packages;
use Illuminate\Database\Seeder;

class PackagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayPackage = [

            [
                'id' => '1',
                'name' => 'Paquete A',
                'price' => '50',
                'categories_id' => '1',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent efficitur dolor velit, vitae aliquam urna posuere in. In lobortis porta ligula ultrices sagittis. Aenean fringilla ornare urna sit amet facilisis. Praesent aliquet erat urna, et varius lectus commodo sit amet. Duis quis diam egestas, fringilla neque nec, sagittis arcu. In elementum fermentum sem, quis viverra ex varius quis. Phasellus viverra lacinia dignissim. Proin mollis nulla at posuer',
            ],
            [
                'id' => '2',
                'name' => 'Paquete B',
                'price' => '100',
                'categories_id' => '1',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent efficitur dolor velit, vitae aliquam urna posuere in. In lobortis porta ligula ultrices sagittis. Aenean fringilla ornare urna sit amet facilisis. Praesent aliquet erat urna, et varius lectus commodo sit amet. Duis quis diam egestas, fringilla neque nec, sagittis arcu. In elementum fermentum sem, quis viverra ex varius quis. Phasellus viverra lacinia dignissim. Proin mollis nulla at posuer',

            ],
            [
                'id' => '3',
                'name' => 'Paquete C',
                'price' => '300',
                'categories_id' => '1',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent efficitur dolor velit, vitae aliquam urna posuere in. In lobortis porta ligula ultrices sagittis. Aenean fringilla ornare urna sit amet facilisis. Praesent aliquet erat urna, et varius lectus commodo sit amet. Duis quis diam egestas, fringilla neque nec, sagittis arcu. In elementum fermentum sem, quis viverra ex varius quis. Phasellus viverra lacinia dignissim. Proin mollis nulla at posuer',

            ],
            [
                'id' => '4',
                'name' => 'Paquete D',
                'price' => '500',
                'categories_id' => '1',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent efficitur dolor velit, vitae aliquam urna posuere in. In lobortis porta ligula ultrices sagittis. Aenean fringilla ornare urna sit amet facilisis. Praesent aliquet erat urna, et varius lectus commodo sit amet. Duis quis diam egestas, fringilla neque nec, sagittis arcu. In elementum fermentum sem, quis viverra ex varius quis. Phasellus viverra lacinia dignissim. Proin mollis nulla at posuer',

            ],
            [
                'id' => '5',
                'name' => 'Paquete E',
                'price' => '1000',
                'categories_id' => '2',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent efficitur dolor velit, vitae aliquam urna posuere in. In lobortis porta ligula ultrices sagittis. Aenean fringilla ornare urna sit amet facilisis. Praesent aliquet erat urna, et varius lectus commodo sit amet. Duis quis diam egestas, fringilla neque nec, sagittis arcu. In elementum fermentum sem, quis viverra ex varius quis. Phasellus viverra lacinia dignissim. Proin mollis nulla at posuer',

            ],
            [
                'id' => '6',
                'name' => 'Paquete F',
                'price' => '2000',
                'categories_id' => '2',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent efficitur dolor velit, vitae aliquam urna posuere in. In lobortis porta ligula ultrices sagittis. Aenean fringilla ornare urna sit amet facilisis. Praesent aliquet erat urna, et varius lectus commodo sit amet. Duis quis diam egestas, fringilla neque nec, sagittis arcu. In elementum fermentum sem, quis viverra ex varius quis. Phasellus viverra lacinia dignissim. Proin mollis nulla at posuer',

            ],
            [
                'id' => '7',
                'name' => 'Paquete G',
                'price' => '3000',
                'categories_id' => '2',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent efficitur dolor velit, vitae aliquam urna posuere in. In lobortis porta ligula ultrices sagittis. Aenean fringilla ornare urna sit amet facilisis. Praesent aliquet erat urna, et varius lectus commodo sit amet. Duis quis diam egestas, fringilla neque nec, sagittis arcu. In elementum fermentum sem, quis viverra ex varius quis. Phasellus viverra lacinia dignissim. Proin mollis nulla at posuer',

            ],
            [
                'id' => '8',
                'name' => 'Paquete H',
                'price' => '5000',
                'categories_id' => '2',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent efficitur dolor velit, vitae aliquam urna posuere in. In lobortis porta ligula ultrices sagittis. Aenean fringilla ornare urna sit amet facilisis. Praesent aliquet erat urna, et varius lectus commodo sit amet. Duis quis diam egestas, fringilla neque nec, sagittis arcu. In elementum fermentum sem, quis viverra ex varius quis. Phasellus viverra lacinia dignissim. Proin mollis nulla at posuer',

            ],
            [
                'id' => '9',
                'name' => 'Paquete I',
                'price' => '10000',
                'categories_id' => '2',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent efficitur dolor velit, vitae aliquam urna posuere in. In lobortis porta ligula ultrices sagittis. Aenean fringilla ornare urna sit amet facilisis. Praesent aliquet erat urna, et varius lectus commodo sit amet. Duis quis diam egestas, fringilla neque nec, sagittis arcu. In elementum fermentum sem, quis viverra ex varius quis. Phasellus viverra lacinia dignissim. Proin mollis nulla at posuer',

            ],

        ];
        foreach ($arrayPackage as $package) {
            Packages::create($package);
        }
    }
}
