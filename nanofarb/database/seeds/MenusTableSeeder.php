<?php

class MenusTableSeeder extends MenusBaseSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('menu_items')->delete();
        DB::table('menus')->delete();
        //DB::table('menu_items')->truncate();
        //DB::table('menus')->truncate();

        $this->seedMenu($this->getData());

        $this->command->info('Menu seed success!');
    }

    public function getData(): array
    {
        return [
            [
                'name' => 'Главное меню',
                'system_name' => 'main_menu',
                'data' => [
                    'has_hierarchy' => 0,
                ],
                'safe' => true,
                'children' => [
                    [
                        'name' => 'Продукция',
                        'path' => 'productions',
                        //'children' => [
                        //    [
                        //        'name' => 'Акции 1',
                        //        'children' => [
                        //            ['name' => 'Акции 11'],
                        //            ['name' => 'Акции 12'],
                        //            ['name' => 'Акции 13'],
                        //            ['name' => 'Акции 14'],
                        //            ['name' => 'Акции 15'],
                        //            ['name' => 'Акции 16'],
                        //        ],
                        //    ],
                        //]
                    ],
                    ['name' => 'О нас', 'path' => 'about'],
                    ['name' => 'Новости', 'path' => 'news'],
                    ['name' => 'Контакты', 'path' => 'contacts'],
                ],
            ],
            [
                'name' => 'Соц. сети',
                'system_name' => 'social_networks',
                'data' => [
                    'has_hierarchy' => 0,
                ],
                'safe' => true,
                'children' => [
                    ['name' => 'Insta', 'path' => 'https://instagram.com', 'target' => '_blank'],
                    ['name' => 'FB', 'path' => 'https://www.facebook.com', 'target' => '_blank'],
                    ['name' => 'VK', 'path' => 'https://vk.com', 'target' => '_blank'],
                ],
            ],
            [
                'name' => 'Меню в подвале "клиентам"',
                'system_name' => 'for_clients',
                'data' => [
                    'has_hierarchy' => 0,
                ],
                'safe' => true,
                'children' => [
                    ['name' => 'Корпоративным клиентам', 'path' => '#'],
                    ['name' => 'Оптовым клиентам', 'path' => '#'],
                ],
            ],

        ];
    }
}
