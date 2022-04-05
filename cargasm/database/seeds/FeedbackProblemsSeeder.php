<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB as DBAlias;

class FeedbackProblemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DBAlias::table('feedback_problems')->insert([
            [
                'problem' => 'Не подошла деталь',
                'weight' => 5,
                'lang' => 'ru',
            ],
            [
                'problem' => 'Не устроило качество',
                'weight' => 4,
                'lang' => 'ru',
            ],
            [
                'problem' => 'Большие сроки доставки',
                'weight' => 3,
                'lang' => 'ru',
            ],
            [
                'problem' => 'Грубость сотрудника',
                'weight' => 2,
                'lang' => 'ru',
            ],
            [
                'problem' => 'Другая проблема',
                'weight' => 1,
                'lang' => 'ru',
            ],
            [
                'problem' => 'Не підійшла деталь',
                'weight' => 5,
                'lang' => 'uk',
            ],
            [
                'problem' => 'Не влаштувала якість',
                'weight' => 4,
                'lang' => 'uk',
            ],
            [
                'problem' => 'Великі терміни доставки',
                'weight' => 3,
                'lang' => 'uk',
            ],
            [
                'problem' => 'Грубість співробітника',
                'weight' => 2,
                'lang' => 'uk',
            ],
            [
                'problem' => 'Інша проблема',
                'weight' => 1,
                'lang' => 'uk',
            ],
        ]);
    }
}
