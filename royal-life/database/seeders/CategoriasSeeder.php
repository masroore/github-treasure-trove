<?php

namespace Database\Seeders;

use App\Models\Categories;
use Illuminate\Database\Seeder;

class CategoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arayCategorias = [
            [
                'id' => '1',
                'categories_name' => 'Aceites CBD',
            ],
            [
                'id' => '2',
                'categories_name' => 'Comestibles',
            ],
            [
                'id' => '3',
                'categories_name' => 'Capsulas',
            ],

        ];
        foreach ($arayCategorias as $categoria) {
            Categories::create($categoria);
        }
    }
}
