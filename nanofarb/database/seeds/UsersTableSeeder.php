<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('users')->delete();

        \DB::table('users')->insert([
            [
                'name' => 'Optimus',
                'last_name' => 'Prime',
                'email' => 'admin@app.com',
                'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
                'email_verified_at' => new \DateTime(),
                'safe' => true,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
            ],
            [
                'name' => 'Bob',
                'last_name' => 'Dilan',
                'email' => 'bob@app.com',
                'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
                'email_verified_at' => new \DateTime(),
                'safe' => false,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
            ],
            [
                'name' => 'Manager',
                'last_name' => null,
                'email' => 'manager@app.com',
                'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
                'email_verified_at' => new \DateTime(),
                'safe' => false,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
            ],
            [
                'name' => 'Seo Manager',
                'last_name' => null,
                'email' => 'seo@app.com',
                'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
                'email_verified_at' => new \DateTime(),
                'safe' => false,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
            ],
            [
                'name' => 'Client',
                'last_name' => 'Test',
                'email' => 'client@app.com',
                'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
                'email_verified_at' => new \DateTime(),
                'safe' => false,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
            ],
        ]);

        $this->command->info('Users seed success!');
    }
}
