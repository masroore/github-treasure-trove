<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $this->call(UsersTableSeeder::class);
        //factory(App\Message::class, 10)->create();
        factory(App\Message::class, 10)->create();
    }
}
