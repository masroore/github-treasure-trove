<?php

use Illuminate\Database\Seeder;

class CdekTariffZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $zones = [
            //1 => ["Москва",],
            //2 => ["Московская обл.",],
            3 => ['Брянск', 'Воронеж', 'Иваново', 'Казань', 'Калуга', 'Кострома', 'Курск', 'Липецк', 'Нижний Новгород', 'Санкт-Петербург', 'Тверь', 'Тула', 'Ярославль', 'Самара', 'Тольятти', 'Владимир', 'Вологда', 'Воронеж', 'Великий Новгород', 'Орел', 'Смоленск'],
            4 => ['Волгоград', 'Краснодар', 'Ростов-на-Дону', 'Саратов', 'Сочи', 'Ставрополь', 'Ульяновск', 'Астрахань', 'Белгород', 'Элиста', 'Киров', 'Саранск', 'Рязань', 'Владикавказ', 'Тамбов', 'Чебоксары', 'Майкоп'],
            5 => ['Екатеринбург', 'Ижевск', 'Йошкар-Ола', 'Магнитогорск', 'Нижнекамск', 'Оренбург', 'Пенза', 'Пермь', 'Петрозаводск', 'Уфа', 'Тюмень', 'Челябинск', 'Псков', 'Набережные Челны', 'Сыктывкар', 'Нальчик', 'Черкесск', 'Курган'],
            6 => ['Барнаул', 'Бийск', 'Кемерово', 'Красноярск', 'Новокузнецк', 'Новосибирск', 'Омск', 'Томск', 'Симферополь', 'Архангельск', 'Магас', 'Горно-Алтайск'],
            7 => ['Благовещенск', 'Владивосток', 'Иркутск', 'Калининград', 'Кызыл', 'Мурманск', 'Надым', 'Находка', 'Нижневартовск', 'Петропавловск-Камчатский', 'Сургут', 'Улан-Удэ', 'Уссурийск', 'Хабаровск', 'Якутск', 'Махачкала', 'Биробиджан', 'Чита', 'Магадан', 'Нарьян-Мар', 'Южно-Сахалинск', 'Абакан', 'Грозный', 'Анадырь'],
        ];

        foreach ($zones as $zone => $cities) {
            foreach ($cities as $city) {
                if ($city == 'Киров') {
                    $cityCapital = \Illuminate\Support\Facades\DB::table('cdek_cities')
                        ->where('city', $city)->where('region', 'Кировская обл.');
                } else {
                    $cityCapital = \Illuminate\Support\Facades\DB::table('cdek_cities')
                        ->where('city', $city);
                }

                if ($cityCapital->first()) {
                    $cityCapital->update(['tariff_zone' => $zone]);
                    \Illuminate\Support\Facades\DB::table('cdek_cities')
                        ->where('region', $cityCapital->first()->region)
                        ->update(['tariff_zone' => $zone]);
                }
            }
        }

        // Ленинградская обл.
        \Illuminate\Support\Facades\DB::table('cdek_cities')
            ->where('region', 'LIKE', 'Ленинградская обл.')
            ->update(['tariff_zone' => 3]);

        // Московская обл. и регион Москва
        \Illuminate\Support\Facades\DB::table('cdek_cities')
            ->where('region', 'LIKE', 'Московская обл.')
            ->orWhere('region', 'Москва')
            ->update(['tariff_zone' => 2]);

        // Город Москва
        \Illuminate\Support\Facades\DB::table('cdek_cities')
            ->where('city', 'Москва')
            ->update(['tariff_zone' => 1]);
    }
}
