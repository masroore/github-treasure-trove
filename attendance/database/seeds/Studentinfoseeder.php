<?php

use Illuminate\Database\Seeder;

class Studentinfoseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // factory(App\Studentinfo::class, 500)->create();
        $users = factory(App\User::class, 300)
            ->create()
            ->each(function ($user): void {
                $user->assignRole('Student');
                $indexnumber = $user->indexnumber;
                $user->studentinfos()->save(factory(App\Studentinfo::class)->create(
                    [
                        'indexnumber' => $indexnumber,
                        'email' => $user->email,
                        'fullname' => $user->name,
                    ]
                ));
            });
    }
}
