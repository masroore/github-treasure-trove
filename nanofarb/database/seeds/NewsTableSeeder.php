<?php

use Illuminate\Database\Seeder;

class NewsTableSeeder extends Seeder
{
    public function run(): void
    {
        $news_count = 1 * env('SEED_NEWS', 5);

        factory(\App\Models\News::class, $news_count)->create();

        $this->command->info('News seed success!');
    }
}
