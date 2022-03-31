<?php

namespace Database\Seeders;

use App\Models\CrmStatus;
use Illuminate\Database\Seeder;

class CrmStatusTableSeeder extends Seeder
{
    public function run()
    {
        $crmStatuses = [
            [
                'id'         => 1,
                'name'       => 'Lead',
                'created_at' => '2021-08-08 20:14:06',
                'updated_at' => '2021-08-08 20:14:06',
            ],
            [
                'id'         => 2,
                'name'       => 'Customer',
                'created_at' => '2021-08-08 20:14:06',
                'updated_at' => '2021-08-08 20:14:06',
            ],
            [
                'id'         => 3,
                'name'       => 'Partner',
                'created_at' => '2021-08-08 20:14:06',
                'updated_at' => '2021-08-08 20:14:06',
            ],
        ];

        CrmStatus::insert($crmStatuses);
    }
}
