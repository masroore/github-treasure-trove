<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(DomainSeeder::class);
        $this->call(LanguageSeeder::class);
        $this->call(MenuSeeder::class);
        $this->call(UserSeeder::class);

        $this->call(AttachLanguageForDomainSeeder::class);
        $this->call(FeedbackProblemsSeeder::class);
        $this->call(CarModelsSeeder::class);

        $this->call(TestDataSeeder::class);
        $this->call(FixMediaSeeder::class);
    }
}
