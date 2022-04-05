<?php

use Illuminate\Database\Seeder;

class ShopTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $product_count = 1 * env('SEED_PRODUCT', 5);
        $order_count = 1 * env('SEED_ORDER', 5);
        $user_count = 1 * env('SEED_USER', 5);
        $review_count = 1 * env('SEED_PRODUCT_REVIEW', 5);
        $products_in_group = 1 * env('SEED_PRODUCT_IN_GROUP', 2);

        $attributes_values = [
            ['title' => 'Вес', 'suffix' => 'кг', 'purpose' => \App\Models\Shop\Attribute::PURPOSE_CARD, 'values' => [0.5, 1, 2, 3, 3.6, 12]],
            ['title' => 'Цвет', 'purpose' => \App\Models\Shop\Attribute::PURPOSE_FACET, 'values' => ['Белый', 'Черный', 'Красный', 'Синий', 'Зеленый', 'Желтый']],
            //['title' => 'Потребность', 'purpose' => \App\Models\Shop\Attribute::PURPOSE_COMBINED, 'values' => ['Восстановление', 'Увлажнение', 'Блеск', 'Объем', 'Защита', 'Против секущихся концов', 'Против выпадения волос', 'Против перхоти', 'Уход за кожей головы',]],
        ];

        $this->command->info('Attributes & values seed start');
        foreach ($attributes_values as $attribute_item) {
            $attribute = \App\Models\Shop\Attribute::updateOrCreate([
                'title' => $attribute_item['title'],
                'suffix' => $attribute_item['suffix'] ?? null,
                'slug' => str_slug($attribute_item['title']), // TODO unique
                'purpose' => $attribute_item['purpose'],
            ]);
            foreach ($attribute_item['values'] ?? [] as $value) {
                $attribute->values()->updateOrCreate([
                    'value' => $value,
                    'suffix' => $attribute->suffix,
                    'slug' => str_slug($value), // TODO unique
                ]);
            }
        }

        $categories = \App\Models\Taxonomy\Term::byVocabulary('product_categories')->get();

        $this->command->info('Categories & attributes seed start');
        $attributes = \App\Models\Shop\Attribute::all();
        foreach ($categories as $category) {
            $attributes_for_sync = $attributes->random(mt_rand(1, $attributes->count()))->pluck('id')->toArray();
            $attributes_for_sync[] = $attributes->first()->id; // TODO
            $category->attrs()->sync($attributes_for_sync);
        }

        $category_ids = $categories->pluck('id')->toArray();

        $this->command->info('Products, related values, product-category sync seed start');
        $values = \App\Models\Shop\Value::pluck('id')->toArray();
        factory(\App\Models\Shop\Product::class, $product_count)->create()->each(function ($product) use ($category_ids): void {
            $values_for_sync = [];
            // Single for card values
            if ($first_val = \App\Models\Shop\Value::select('id')->whereHas('attribute', function ($a): void {
                $a->where('purpose', \App\Models\Shop\Attribute::PURPOSE_CARD);
            })->inRandomOrder()->first()) {
                $values_for_sync[] = $first_val->id;
            }

            // Multiple values for facet
            $facet_values = \App\Models\Shop\Value::select('id')->whereHas('attribute', function ($a): void {
                $a->where('purpose', \App\Models\Shop\Attribute::PURPOSE_FACET);
            })->inRandomOrder()->limit(mt_rand(1, 5))->get()->pluck('id')->toArray();
            $values_for_sync = array_merge($values_for_sync, $facet_values);

            $product->values()->sync($values_for_sync);
            $categories = array_random($category_ids, mt_rand(1, 3));
            $product->txCategories()->sync($categories);
        });

        $this->command->info('Product groups & update main category seed start');
        \App\Models\Shop\Product::chunk($products_in_group, function ($products) use ($category_ids): void {
            $group = \App\Models\Shop\ProductGroup::create(['default_product_id' => $products->first()->id]);
            $categoryId = array_random($category_ids);
            $products->each(function ($product) use ($group, $categoryId): void {
                $product->product_group_id = $group->id;
                $product->category_id = $categoryId;
                $product->save();

                $product->terms()->syncWithoutDetaching([$categoryId]);

                // refresh url aliases
                if ($product->urlAlias) {
                    $alias = $product->generateUrlAlias();
                    $product->urlAlias()->update(['alias' => $alias]);
                }
            });
        });

        $this->command->info('Users & contacts seed start');
        factory(\App\Models\User::class, $user_count)->create()->each(function ($user): void {
            factory(\App\Models\Contact::class, 3)->create(['user_id' => $user->id]);
            $user->setAttribute('contact_id', $user->contacts->first()->id);
            $user->save();
        });

        $this->command->info('Orders seed start');
        factory(\App\Models\Shop\Order::class, $order_count)->create()->each(function ($order): void {
            $products = \App\Models\Shop\Product::inRandomOrder()->limit(mt_rand(1, 3))->get();
            $data = [];
            foreach ($products as $product) {
                $data[$product->id] = [
                    'price' => $product->price,
                    'currency' => $product->currency,
                    'quantity' => mt_rand(1, 3),
                    //'discount' => 0,
                ];
            }
            $order->products()->attach($data);
        });

        $this->command->info('Calculate product rating start');
        $this->command->call('shop:product-rating-calculate', [
            '--force' => true,
        ]);

        $this->command->info('Product reviews seed start');
        factory(\App\Models\Shop\ProductReview::class, $review_count)->create();

        // Sales
        $this->call(ProductSalesTableSeeder::class);
    }
}
