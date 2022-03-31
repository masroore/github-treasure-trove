<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Un Guard model
        Model::unguard();

        $this->command->call('migrate:fresh');

        $this->command->info('Refreshing database...');
        $this->command->comment('Refreshed!');

        $this->call(UsersSeeder::class);
        $this->command->comment('Users created!');

        $this->call(CategorySeeder::class);
        $this->command->comment('Categories created!');

        $this->call(PageSeeder::class);
        $this->command->comment('Pages created!');

        $this->call(WidgetSeeder::class);
        $this->command->comment('Widgets created!');

        $this->command->comment('Enjoy your app!');
        $this->command->line('...');

        // ReGuard model
        Model::reguard();
    }
}
