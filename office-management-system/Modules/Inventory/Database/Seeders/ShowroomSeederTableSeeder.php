<?php

namespace Modules\Inventory\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Account\Entities\ChartAccount;
use Modules\Inventory\Entities\ShowRoom;

class ShowroomSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();

        ShowRoom::insert([
            [
                'name' => 'Mirpur Branch',
                'email' => 'mirpur@gmail.com',
                'address' => 'Mirpur 10, Dhaka.',
                'phone' => '0198483748316',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => '2020-11-06 05:41:22',
                'updated_at' => '2020-11-06 05:41:22',

            ],
            [
                'name' => 'Uttora Branch',
                'email' => 'uttora@gmail.com',
                'address' => 'Uttara, sector 10',
                'phone' => '019848374833',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => '2020-11-06 09:34:17',
                'updated_at' => '2020-11-06 09:34:17',
            ],
            [
                'name' => 'Feni Branch',
                'email' => 'feni@gmail.com',
                'address' => 'Trunk Road, Feni',
                'phone' => '0198483748',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => '2020-11-06 09:34:17',
                'updated_at' => '2020-11-06 09:34:17',
            ],

        ]);

        ChartAccount::insert([
            [
                'code' => '01-01-17',
                'level' => 2,
                'is_group' => 0,
                'name' => 'Mirpur Branch',
                'type' => '1',
                'configuration_group_id' => 1,
                'description' => null,
                'parent_id' => 1,
                'status' => 1,
                'contactable_type' => 'Modules\\Inventory\\Entities\\ShowRoom',
                'contactable_id' => 2,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2020-11-06 05:41:22',
                'updated_at' => '2020-11-06 05:41:22',
            ],
            [
                'code' => '01-01-18',
                'level' => 2,
                'is_group' => 0,
                'name' => 'Uttora Branch',
                'type' => '1',
                'configuration_group_id' => 1,
                'description' => null,
                'parent_id' => 1,
                'status' => 1,
                'contactable_type' => 'Modules\\Inventory\\Entities\\ShowRoom',
                'contactable_id' => 3,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2020-11-06 05:41:22',
                'updated_at' => '2020-11-06 05:41:22',
            ],
            [
                'code' => '01-01-19',
                'level' => 2,
                'is_group' => 0,
                'name' => 'Feni Branch',
                'type' => '1',
                'configuration_group_id' => 1,
                'description' => null,
                'parent_id' => 1,
                'status' => 1,
                'contactable_type' => 'Modules\\Inventory\\Entities\\ShowRoom',
                'contactable_id' => 4,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2020-11-06 05:41:22',
                'updated_at' => '2020-11-06 05:41:22',
            ],

        ]);
    }
}
