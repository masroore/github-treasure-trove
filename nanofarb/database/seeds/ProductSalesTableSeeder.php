<?php

use Illuminate\Database\Seeder;

class ProductSalesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Sales seed start');
        //factory(\App\Models\Shop\Sale::class, $sales_count)->create();
        $start_at = \Carbon\Carbon::now()->subDay(3)->format('Y-m-d H:i:s');
        $end_at = \Carbon\Carbon::now()->addDay(8)->format('Y-m-d H:i:s');
        $sales = [
            [
                'name' => 'Акция 25% на товары категории',
                'description' => 'Акция 25% на товары категории Акция 25% на товары категории',
                'discount_type' => \App\Models\Shop\Sale::DISCOUNT_TYPE_PERCENT,
                'discount' => 25,
                'type' => \App\Models\Shop\Sale::TYPE_PRODUCT,
                'dateless' => 1,
                'start_at' => $start_at,
                'end_at' => $end_at,
            ],
            //[
            //    'name' => 'Акция 250 руб. на товары категории по промокоду',
            //    'description' => 'Акция 250 руб. на товары категории Акция 250 руб. на товары категории',
            //    'discount_type' => \App\Models\Shop\Sale::DISCOUNT_TYPE_SUM,
            //    'discount' => 25000,
            //    'type' => \App\Models\Shop\Sale::TYPE_PROM_CODE_PRODUCT,
            //    'dateless' => 1,
            //    'start_at' => $start_at,
            //    'end_at' => $end_at,
            //],
            [
                'name' => 'Бесплатная доставка по промокоду',
                'description' => 'Бесплатная доставка по промокоду Бесплатная доставка по промокоду',
                'discount_type' => \App\Models\Shop\Sale::DISCOUNT_TYPE_PERCENT,
                'discount' => 0,
                'type' => \App\Models\Shop\Sale::TYPE_PROM_CODE_FREE_ORDER,
                'dateless' => 1,
                'start_at' => $start_at,
                'end_at' => $end_at,
            ],
            [
                'publish' => 0,
                'name' => 'Бесплатная доставка',
                'description' => 'Бесплатная доставка Бесплатная доставка',
                'discount_type' => \App\Models\Shop\Sale::DISCOUNT_TYPE_PERCENT,
                'discount' => 0,
                'type' => \App\Models\Shop\Sale::TYPE_FREE_SHIPPING_CONDITIONS,
                'dateless' => 1,
                'start_at' => $start_at,
                'end_at' => $end_at,
            ],
            [
                'publish' => 0,
                'name' => 'Скидка 10% на суму заказа по промокоду',
                'description' => 'Скидка 10% на общую суму заказа по промокоду',
                'discount_type' => \App\Models\Shop\Sale::DISCOUNT_TYPE_PERCENT,
                'discount' => 10,
                'type' => \App\Models\Shop\Sale::TYPE_PROM_CODE_DISCOUNT_SUM_ORDER,
                'dateless' => 1,
                'start_at' => $start_at,
                'end_at' => $end_at,
            ],
        ];

        array_map(function ($sale): void {
            \App\Models\Shop\Sale::create($sale);
        }, $sales);

        \App\Models\Shop\Sale::all()->map(function ($sale): void {
            // refresh url aliases
            if ($sale->urlAlias) {
                $alias = $sale->generateUrlAlias();
                $sale->urlAlias()->update(['alias' => $alias]);
            }
        });
    }
}
