<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            [
                'name' => 'Главное меню',
                'slug' => 'main',
                'items' => [
                    [
                        'type' => \App\Models\MenuItem::TYPE_PATH,
                        'name' => 'Магазин',
                    ],
                    [
                        'type' => \App\Models\MenuItem::TYPE_PATH,
                        'name' => 'События',
                    ],
                    [
                        'type' => \App\Models\MenuItem::TYPE_PATH,
                        'name' => 'Новости',
                    ],
                    [
                        'type' => \App\Models\MenuItem::TYPE_PATH,
                        'name' => 'Блог',
                        'path' => 'blogs',
                    ],
                    [
                        'type' => \App\Models\MenuItem::TYPE_PATH,
                        'name' => 'Видео',
                    ],
                    [
                        'type' => \App\Models\MenuItem::TYPE_PATH,
                        'name' => 'Поиск СТО',
                        'path' => 'sto',
                    ],
                ],
            ],

            [
                'name' => 'Политика',
                'slug' => 'policy',
                'items' => [
                    [
                        'type' => \App\Models\MenuItem::TYPE_PATH,
                        'name' => 'Политика конфиденциальности',
                    ],
                    [
                        'type' => \App\Models\MenuItem::TYPE_PATH,
                        'name' => 'Правила использования информации',
                    ],
                ],
            ],

            [
                'name' => 'Соц. сети',
                'slug' => 'social',
                'items' => [
                    [
                        'type' => \App\Models\MenuItem::TYPE_PATH,
                        'name' => 'VK',
                        'img' => '/images/vk.svg',
                    ],
                    [
                        'type' => \App\Models\MenuItem::TYPE_PATH,
                        'name' => 'IN',
                        'img' => '/images/instagram.svg',
                    ],
                    [
                        'type' => \App\Models\MenuItem::TYPE_PATH,
                        'name' => 'TG',
                        'img' => '/images/telegram.svg',
                    ],
                    [
                        'type' => \App\Models\MenuItem::TYPE_PATH,
                        'name' => 'VB',
                        'img' => '/images/viber.svg',
                    ],
                ],
            ],

            [
                'name' => 'Cargasm',
                'slug' => 'cargasm',
                'items' => [
                    [
                        'type' => \App\Models\MenuItem::TYPE_PATH,
                        'name' => 'События',
                    ],
                    [
                        'type' => \App\Models\MenuItem::TYPE_PATH,
                        'name' => 'Новости',
                    ],
                    [
                        'type' => \App\Models\MenuItem::TYPE_PATH,
                        'name' => 'Блог',
                        'path' => 'blogs',
                    ],
                    [
                        'type' => \App\Models\MenuItem::TYPE_PATH,
                        'name' => 'Видео',
                    ],
                    [
                        'type' => \App\Models\MenuItem::TYPE_PATH,
                        'name' => 'Поиск СТО',
                        'path' => 'sto',
                    ],
                    [
                        'type' => \App\Models\MenuItem::TYPE_DELIMITER,
                        'name' => '---',
                    ],
                    [
                        'type' => \App\Models\MenuItem::TYPE_PATH,
                        'name' => 'О нас',
                    ],
                    [
                        'type' => \App\Models\MenuItem::TYPE_PATH,
                        'name' => 'Партнеры',
                    ],
                ],
            ],

            [
                'name' => 'Магазин',
                'slug' => 'shop',
                'items' => [
                    [
                        'type' => \App\Models\MenuItem::TYPE_PATH,
                        'name' => 'Каталог',
                    ],
                    [
                        'type' => \App\Models\MenuItem::TYPE_PATH,
                        'name' => 'Контроль качества',
                    ],
                    [
                        'type' => \App\Models\MenuItem::TYPE_PATH,
                        'name' => 'Контракты',
                    ],
                    [
                        'type' => \App\Models\MenuItem::TYPE_PATH,
                        'name' => 'Корзина',
                    ],
                    [
                        'type' => \App\Models\MenuItem::TYPE_DELIMITER,
                        'name' => '---',
                    ],
                    [
                        'type' => \App\Models\MenuItem::TYPE_PATH,
                        'name' => 'Как мы работаем',
                    ],
                    [
                        'type' => \App\Models\MenuItem::TYPE_PATH,
                        'name' => 'Наши преимущества',
                    ],
                    [
                        'type' => \App\Models\MenuItem::TYPE_PATH,
                        'name' => 'Оплата и доставка',
                    ],
                ],
            ],

            [
                'name' => 'Поддержка',
                'slug' => 'support',
                'items' => [
                    [
                        'type' => \App\Models\MenuItem::TYPE_PATH,
                        'name' => '8 800 222-49-25',
                        'path' => 'tel:88002224925',
                        'img' => '/images/phone.svg',
                    ],
                    [
                        'type' => \App\Models\MenuItem::TYPE_PATH,
                        'name' => 'support@cargasm.ru',
                        'path' => 'mailto:support@cargasm.ru',
                        'img' => '/images/email.svg',
                    ],
                ],
            ],
        ];

        foreach ($menus as $menu) {
            $menuModel = \App\Models\Menu::updateOrCreate(Arr::only($menu, 'slug'), Arr::only($menu, 'name'));
            foreach ($menu['items'] ?? [] as $item) {
                $translationUuid = null;
                foreach (\App\Models\Language::all() as $language) {
                    if ($translationUuid === null) {
                        $translationUuid = \Illuminate\Support\Str::uuid();
                    }
                    $menuModel->items()->updateOrCreate(
                        Arr::only($item, 'name') + [
                            'lang' => $language->lang,
                        ],
                        Arr::only($item, ['type', 'path', 'img']) + [
                            'translation_uuid' => $translationUuid,
                        ]
                    );
                }
            }
        }
    }
}
