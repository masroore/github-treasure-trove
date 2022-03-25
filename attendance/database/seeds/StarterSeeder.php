<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class StarterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = ['is_admin', 'is_superAdmin', 'Student', 'Lecturer', 'Accounts', 'Head Of Academics', 'Academic Committee', 'Developer'];

        $count = count($data);

        for ($i = 0; $i < $count; $i++) {
            Role::create(['name'=> $data[$i]]);
        }

        $user = new \App\User([
            'name'=> 'Ahmed Ahia',
            'email' => 'admin@admin.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        ]);

        $user->save();
        $user->assignRole('is_admin');
    }
}
