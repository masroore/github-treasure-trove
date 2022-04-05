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
            ],
            [
                'id' => '2',
                'name' => 'Paquete B',
                'price' => '100',
            ],
            [
                'id' => '3',
                'name' => 'Paquete C',
                'price' => '300',
            ],
            [
                'id' => '4',
                'name' => 'Paquete D',
                'price' => '500',
            ],
            [
                'id' => '5',
                'name' => 'Paquete E',
                'price' => '1000',
            ],
            [
                'id' => '6',
                'name' => 'Paquete F',
                'price' => '2000',
            ],
            [
                'id' => '7',
                'name' => 'Paquete G',
                'price' => '3000',
            ],
            [
                'id' => '8',
                'name' => 'Paquete H',
                'price' => '5000',
            ],
            [
                'id' => '9',
                'name' => 'Paquete I',
                'price' => '10000',
            ],

        ];
        foreach ($arrayPackage as $package) {
            Packages::create($package);
        }
    }
}
