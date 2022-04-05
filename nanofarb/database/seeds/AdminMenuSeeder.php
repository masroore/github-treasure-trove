<?php

class AdminMenuSeeder extends MenusBaseSeeder
{
    public function run(): void
    {
        //if ($menu = \App\Models\Menu\Menu::where('system_name', 'admin_menu')->first()) {
        //    $menu->delete();
        //}

        $this->seedMenu($this->getData());

        $this->command->info('Menu seed success!');
    }

    public function getData(): array
    {
        return [

            [
                'name' => 'Админ. меню',
                'system_name' => 'admin_menu',
                'data' => [
                    'has_hierarchy' => 1,
                ],
                'safe' => true,
                'children' => [
                    [
                        'name' => 'Меню',
                        'path' => '',
                        'data' => [
                            'permissions' => [],
                            'icon' => '',
                            'header' => 1,
                        ],
                    ],

                    [
                        'name' => 'Главная',
                        'path' => route('admin.home'),
                        'data' => [
                            'permissions' => ['dashboard.home.read'],
                            'icon' => 'fa fa-dashboard',
                            'pattern_url' => '\S*admin\/?((\?{1}\S*)|$)',
                        ],
                    ],

                    [
                        'name' => 'Материалы',
                        'path' => '',
                        'data' => [
                            'permissions' => [],
                            'icon' => 'fa fa-file-text-o',
                        ],
                        'children' => [
                            [
                                'name' => 'Товары',
                                'path' => route('admin.products.index'),
                                'data' => [
                                    'permissions' => ['product.read'],
                                    'icon' => '',
                                    //'pattern_url' => '\S*admin\/products\S*',
                                ],
                            ],
                            [
                                'name' => 'Страницы',
                                'path' => route('admin.pages.index'),
                                'data' => [
                                    'permissions' => ['page.read'],
                                    'icon' => '',
                                    //'pattern_url' => '\S*admin\/pages\S*',
                                ],
                            ],
                            [
                                'name' => 'Новости',
                                'path' => route('admin.news.index'),
                                'data' => [
                                    'permissions' => ['news.read'],
                                    'icon' => '',
                                    //'pattern_url' => '\S*admin\/pages\S*',
                                ],
                            ],
                            [
                                'name' => 'Акции',
                                'path' => route('admin.sales.index'),
                                'data' => [
                                    'permissions' => ['sale.read'],
                                    'icon' => '',
                                    'pattern_url' => '',
                                ],
                            ],
                        ],
                    ],

                    [
                        'name' => 'Структура',
                        'path' => '',
                        'data' => [
                            'permissions' => [],
                            'icon' => 'fa fa-th',
                        ],
                        'children' => [
                            [
                                'name' => 'Рубрикатор',
                                'path' => '',
                                'data' => [
                                    'permissions' => [],
                                    'icon' => '',
                                ],
                                'children' => [
                                    [
                                        'name' => 'Категории товаров',
                                        'path' => route('admin.terms.index', ['vocabulary' => 'product_categories']),
                                        'data' => [
                                            'permissions' => ['term.read'],
                                            'icon' => '',
                                            'pattern_url' => '\S*vocabulary=product_categories\S*',
                                        ],
                                    ],
                                    [
                                        'name' => 'Статусы заказов',
                                        'path' => route('admin.terms.index', ['vocabulary' => 'order_statuses']),
                                        'data' => [
                                            'permissions' => ['term.read'],
                                            'icon' => '',
                                            'pattern_url' => '\S*vocabulary=order_statuses\S*',
                                        ],
                                    ],
                                    [
                                        'name' => 'Статусы оплат',
                                        'path' => route('admin.terms.index', ['vocabulary' => 'payment_statuses']),
                                        'data' => [
                                            'permissions' => ['term.read'],
                                            'icon' => '',
                                            'pattern_url' => '\S*vocabulary=payment_statuses\S*',
                                        ],
                                    ],
                                    [
                                        'name' => 'Виды торг. услуг',
                                        'path' => route('admin.terms.index', ['vocabulary' => 'types_trade_services']),
                                        'data' => [
                                            'permissions' => ['term.read'],
                                            'icon' => '',
                                            'pattern_url' => '\S*vocabulary=types_trade_services\S*',
                                        ],
                                    ],
                                    //[
                                    //    'name' => 'Темы для FAQ',
                                    //    'path' => route('admin.terms.index', ['vocabulary' => 'faq_subjects']),
                                    //    'data' => [
                                    //        'permissions' => ['term.read'],
                                    //        'icon' => '',
                                    //        'pattern_url' => '\S*vocabulary=faq_subjects\S*',
                                    //    ]
                                    //],
                                ],
                            ],
                            [
                                'name' => 'Атрибуты',
                                'path' => route('admin.attributes.index'),
                                'data' => [
                                    'permissions' => ['attribute.read'],
                                    'icon' => '',
                                    'pattern_url' => '\S*admin\/shop\/(values|attributes)\S*',
                                ],
                            ],
                            [
                                'name' => 'Меню',
                                'path' => route('admin.menu.index'),
                                'data' => [
                                    'permissions' => ['menu.read'],
                                    'icon' => '',
                                ],
                            ],
                        ],
                    ],

                    [
                        'name' => 'SEO',
                        'path' => '',
                        'data' => [
                            'permissions' => [],
                            'icon' => 'fa fa-rocket',
                        ],
                        'children' => [
                            [
                                'name' => 'URL-перенаправления',
                                'path' => route('admin.url-aliases.index'),
                                'data' => [
                                    'permissions' => ['url-alias.read'],
                                    'icon' => '',
                                    'pattern_url' => '\S*url-aliases\/?$',
                                ],
                            ],
                            [
                                'name' => 'Мета-теги путей',
                                'path' => route('admin.meta-tags.index'),
                                'data' => [
                                    'permissions' => ['meta-tag.read'],
                                    'icon' => '',
                                    'pattern_url' => '\S*meta-tags\S*',
                                ],
                            ],
                            [
                                'name' => 'Карта сайта',
                                'path' => route('admin.site-map.edit'),
                                'data' => [
                                    'permissions' => ['site-map.update'],
                                    'icon' => '',
                                    'pattern_url' => '\S*site-map\S*',
                                ],
                            ],
                        ],
                    ],

                    [
                        'name' => 'Конфигурации',
                        'path' => '',
                        'data' => [
                            'permissions' => [],
                            'icon' => 'fa fa-cogs',
                        ],
                        'children' => [
                            [
                                'name' => 'Настройка системы',
                                'path' => route('admin.variable.forms'),
                                'data' => [
                                    'permissions' => ['variable.read'],
                                    'icon' => '',
                                    'pattern_url' => '\S*variables\/?$',
                                ],
                            ],
                            [
                                'name' => 'API-сервисы',
                                'path' => route('admin.variable.forms', ['form' => 'api']),
                                'data' => [
                                    'permissions' => ['variable.read'],
                                    'icon' => '',
                                    'pattern_url' => '\S*form=api\S*',
                                ],
                            ],
                            [
                                'name' => 'Магазин',
                                'path' => route('admin.variable.forms', ['form' => 'shop']),
                                'data' => [
                                    'permissions' => ['variable.read'],
                                    'icon' => '',
                                    'pattern_url' => '\S*form=shop\S*',
                                ],
                            ],
                            [
                                'name' => 'Внешнии площадки',
                                'path' => route('admin.variable.forms', ['form' => 'external']),
                                'data' => [
                                    'permissions' => ['variable.read'],
                                    'icon' => '',
                                    'pattern_url' => '\S*form=external\S*',
                                ],
                            ],
                            [
                                'name' => 'Logs',
                                'path' => url('admin/logs'),
                                'data' => [
                                    'permissions' => ['variable.read'],
                                    'icon' => '',
                                    'pattern_url' => '\S*admin\/logs\S*',
                                ],
                            ],
                            [
                                'name' => 'Очистить кеш',
                                'path' => route('admin.service.cache-clear'),
                                'data' => [
                                    'permissions' => [],
                                    'icon' => '',
                                ],
                            ],
                        ],
                    ],

                    [
                        'name' => 'Веб-формы',
                        'path' => '',
                        'data' => [
                            'permissions' => [],
                            'icon' => 'fa fa-chrome',
                        ],
                        'children' => [
                            //[
                            //    'name' => 'Подписчики',
                            //    'path' => '/admin/forms/subscribers',
                            //    'data' => [
                            //        'permissions' => ['form.read',],
                            //        'icon' => '',
                            //    ],
                            //],
                            //[
                            //    'name' => 'Контакты',
                            //    'path' => '/admin/forms/contacts',
                            //    'data' => [
                            //        'permissions' => ['form.read',],
                            //        'icon' => '',
                            //    ],
                            //],
                            [
                                'name' => 'Отзывы о товарах',
                                'path' => '/admin/product-reviews',
                                'data' => [
                                    'permissions' => ['form.read'],
                                    'icon' => '',
                                ],
                            ],
                            [
                                'name' => 'Заявки',
                                'path' => '/admin/forms/request',
                                'data' => [
                                    'permissions' => ['form.read'],
                                    'icon' => '',
                                ],
                            ],
                        ],
                    ],

                    [
                        'name' => 'Заказы',
                        'path' => '',
                        'data' => [
                            'permissions' => ['order.read'],
                            'icon' => 'fa fa-shopping-cart',
                        ],
                        'children' => [
                            [
                                'name' => 'Локальные',
                                'path' => route('admin.orders.index'),
                                'data' => [
                                    'permissions' => ['form.read'],
                                    'icon' => '',
                                    'pattern_url' => '\S*admin\/orders\S*',
                                ],
                            ],
                            [
                                'name' => 'Rozetka.ua',
                                'path' => '/admin/externalshop/rozetka/orders',
                                'data' => [
                                    'permissions' => ['form.read'],
                                    'icon' => '',
                                    'pattern_url' => '\S*externalshop\/rozetka\/orders\S*',
                                ],
                            ],
                            [
                                'name' => 'Prom.ua',
                                'path' => '/admin/externalshop/prom/orders',
                                'data' => [
                                    'permissions' => ['form.read'],
                                    'icon' => '',
                                    'pattern_url' => '\S*externalshop\/prom\/orders\S*',
                                ],
                            ],
                        ],
                    ],

                    [
                        'name' => 'Пользователи',
                        'path' => route('admin.users.index'),
                        'data' => [
                            'permissions' => ['user.read'],
                            'icon' => 'fa fa-users',
                        ],
                    ],

                ],
            ],
        ];
    }
}
