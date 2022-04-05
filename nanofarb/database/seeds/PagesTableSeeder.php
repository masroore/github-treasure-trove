<?php

use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'name' => 'Главная',
                'blade' => 'front.pages.home',
                'url_alias' => '/',
                'safe' => 1,
            ],
            [
                'name' => 'О нас',
                'body' => '',
                'blade' => 'front.pages.about',
                'url_alias' => 'about',
                'safe' => 1,
            ],
            [
                'name' => 'Контакты',
                'blade' => 'front.pages.contacts',
                'body' => '<p>Страница в стадии наполнения...</p>',
                'url_alias' => 'contacts',
            ],
            [
                'name' => 'Страница по умолчанию - пример',
                'blade' => null,
                'body' => '<h1>Заголовок H1 - страница типографики</h1><h2>Заголовок H2 - страница типографики</h2><p>Абзац с текстом - страница типографики</p>',
                'url_alias' => 'page-example',
            ],
        ];

        foreach ($pages as $item) {
            $page = \App\Models\Page::create([
                'name' => $item['name'],
                'body' => $item['body'] ?? null,
                'blade' => $item['blade'] ?? null,
                'safe' => $item['safe'] ?? 0,
            ]);
            $page->urlAlias()->updateOrCreate([], [
                'alias' => $item['url_alias'],
                'source' => $page->generateUrlSource(),
            ]);
        }

        $this->command->info('Pages seed success!');
    }
}
