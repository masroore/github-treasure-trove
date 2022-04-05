<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionTableSeeder::class,
            UsersTableSeeder::class,
            SmtpTableSeeder::class,
            TemplateTableSeeder::class,
            CmsPagesTableSeeder::class,

        ]);
    }
}
