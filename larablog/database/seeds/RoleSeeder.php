<?php

use App\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'SuperAdmin',
        ]);

        $admin = Role::create([
            'name' => 'Admin',
        ]);

        Role::create([
            'name' => 'Author',
        ]);

        $admin->permissions()->sync([1, 2, 4, 5, 7, 8, 9, 11, 12, 13, 15, 16, 17, 19, 20, 21], false);
    }
}
