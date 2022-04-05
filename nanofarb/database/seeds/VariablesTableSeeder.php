<?php

use Illuminate\Database\Seeder;

class VariablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('variables')->truncate();

        DB::table('variables')->insert([
            [
                'key' => 'app_name',
                'value' => config('app.name'),
            ],
            [
                'key' => 'mail_from_address',
                'value' => 'no-reply@info.net',
            ],
            [
                'key' => 'mail_from_name',
                'value' => config('app.name'),
            ],
            [
                'key' => 'mail_to_address',
                'value' => 'itspace.001@gmail.com',
            ],
            [
                'key' => 'mail_to_name',
                'value' => 'Its Test',
            ],
            [
                'key' => 'company_email',
                'value' => 'namemail@mail.com',
            ],
            [
                'key' => 'company_phone',
                'value' => '+7-900-000-00-00',
            ],
            [
                'key' => 'company_work_schedule',
                'value' => 'Пн-Пт, с 10:05 до 18:05',
            ],

            [
                'key' => 'contact_latitude',
                'value' => '55.759616',
            ],
            [
                'key' => 'contact_longitude',
                'value' => '37.625457',
            ],
            [
                'key' => 'contact_map_zoom',
                'value' => '18',
            ],

            [
                'key' => 'payment_methods',
                'value' => '[{"key":"upon_receipt","value":"\u041e\u043f\u043b\u0430\u0442\u0430 \u043f\u0440\u0438 \u043f\u043e\u043b\u0443\u0447\u0435\u043d\u0438\u0438","safe":"1"},{"key":"prepaid_card","value":"\u041f\u0440\u0435\u0434\u043e\u043f\u043b\u0430\u0442\u0430 \u043d\u0430 \u043a\u0430\u0440\u0442\u0443","safe":"1"}]',
            ],

            [
                'key' => 'delivery_pickup_address',
                'value' => 'г. Киев, 1-й варшавский проезд, 2 стр. 9а',
            ],
            [
                'key' => 'delivery_novaposhta_price',
                'value' => 55,
            ],
            [
                'key' => 'delivery_novaposhta_courier_desc',
                'value' => 'Курьер свяжется с вами для уточнения адреса доставки',
            ],

            [
                'key' => 'phones_header',
                'value' => '["+7 (812) 507-82-10","+7 (812) 507-82-11","+7 (812) 507-82-12"]',
            ],
            [
                'key' => 'company_schedule_map',
                'value' => '<p> <span>Пн - Пт:</span>10:00 - 19:00</p><p> <span>Сб: </span>10:00 - 16:00</p><p> <span>Вс:</span>Выходной</p>',
            ],
            [
                'key' => 'company_schedule_footer',
                'value' => '<div class="footer-work"><div class="footer-name">Будние дни</div><div class="footer-text">10:00 - 19:00</div></div><div class="footer-work"><div class="footer-name">Суббота:</div><div class="footer-text">10:00 - 16:00</div></div><div class="footer-work"><div class="footer-name">Воскресенье:</div><div class="footer-text">Выходной</div></div>',
            ],
            [
                'key' => 'product_cart_icons',
                'value' => '[{"key":"\u0414\u043e\u0441\u0442\u0430\u0432\u043a\u0430 \u043f\u043e \u0432\u0441\u0435\u0439 \u0420\u043e\u0441\u0441\u0438\u0438","value":"\u0414\u043e\u0441\u0442\u0430\u0432\u043a\u0430 \u043f\u043e \u0432\u0441\u0435\u0439 \u0420\u043e\u0441\u0441\u0438\u0438 - \u043e\u043f\u0438\u0441\u0430\u043d\u0438\u0435"},{"key":"\u0413\u0430\u0440\u0430\u043d\u0442\u0438\u044f \u043a\u0430\u0447\u0435\u0441\u0442\u0432\u0430","value":"\u0413\u0430\u0440\u0430\u043d\u0442\u0438\u044f \u043a\u0430\u0447\u0435\u0441\u0442\u0432\u0430- \u043e\u043f\u0438\u0441\u0430\u043d\u0438\u0435"},{"key":"\u0412\u043e\u0437\u0432\u0440\u0430\u0442 \u0432 \u0442\u0435\u0447\u0435\u043d\u0438\u0438 14 \u0434\u043d\u0435\u0439","value":"\u0412\u043e\u0437\u0432\u0440\u0430\u0442 \u0432 \u0442\u0435\u0447\u0435\u043d\u0438\u0438 14 \u0434\u043d\u0435\u0439 - \u043e\u043f\u0438\u0441\u0430\u043d\u0438\u0435"}]',
            ],
            [
                'key' => 'page_home_titles',
                'value' => '<h1>Краски, лаки, клей и грунтовка</h1><h2>Производим и продаем</h2>',
            ],
        ]);

        \Cache::forget('laravel.variables.cache');

        $this->command->info('Vars seed success!');
    }
}
