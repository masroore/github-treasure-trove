<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\Modules\Product\Entities\Product::class, function (Faker $faker) {
    $unit_type = \Modules\Product\Entities\UnitType::inRandomOrder()->first();
    $brand = \Modules\Product\Entities\Brand::inRandomOrder()->first();
    $model = \Modules\Product\Entities\ModelType::inRandomOrder()->first();
    $category = \Modules\Product\Entities\Category::where('parent_id', null)->inRandomOrder()->first();
    $sub_category = \Modules\Product\Entities\Category::where('parent_id', '!=', null)->inRandomOrder()->first();

    return [
        'product_name' => $faker->name,
        'model_id' => $model->id,
        'product_sku' => $faker->isbn10,
        'barcode_type' => $faker->isbn10,
        'unit_type_id' => $unit_type->id,
        'brand_id' => $brand->id,
        'category_id' => $category->id,
        'sub_category_id' => $sub_category->id ?? null,
        'description' => $faker->text(20),
        'created_by' => 1,
        'updated_by' => 1,
    ];
});
