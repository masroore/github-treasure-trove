<?php

use Illuminate\Database\Seeder;

class ModelHasRolesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {

       // \DB::table('model_has_roles')->delete();

        \DB::table('model_has_roles')->insert([
            0 => [
                'role_id' => 1,
                'model_type' => 'App\\User',
                'model_id' => 1,
            ],
            1 => [
                'role_id' => 3,
                'model_type' => 'App\\User',
                'model_id' => 3,
            ],
            2 => [
                'role_id' => 3,
                'model_type' => 'App\\User',
                'model_id' => 14,
            ],
            3 => [
                'role_id' => 3,
                'model_type' => 'App\\User',
                'model_id' => 20,
            ],
            4 => [
                'role_id' => 3,
                'model_type' => 'App\\User',
                'model_id' => 21,
            ],
            5 => [
                'role_id' => 3,
                'model_type' => 'App\\User',
                'model_id' => 22,
            ],
            6 => [
                'role_id' => 3,
                'model_type' => 'App\\User',
                'model_id' => 23,
            ],
            7 => [
                'role_id' => 4,
                'model_type' => 'App\\User',
                'model_id' => 5,
            ],
            8 => [
                'role_id' => 6,
                'model_type' => 'App\\User',
                'model_id' => 15,
            ],
        ]);
    }
}
