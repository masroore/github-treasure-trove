<?php

use App\Models\Category;
use App\Models\Option;
use App\Models\OptionValue;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductGallery;
use App\Models\ProductOption;
use App\Models\ProductOptionValue;
use App\Models\ProductRelatedProduct;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryArray = ['Birthday', 'Holiday', 'Anniversary', 'New Year'];
        $categoryImageArray = ['21.jpg', '20.jpg', '22.jpg', '23.jpg'];

        for ($i = 0; $i < 4; ++$i) {
            $category = Category::create([
                'name' => $categoryArray[$i],
                'image' => $categoryImageArray[$i],
                'slug' => strtolower($categoryArray[$i]),
                'description' => 'This is description for ' . $categoryArray[$i] . ' category.',
            ]);
        }

        // for one product 1

        $option = Option::create([
            'name' => 'Size',
            'type' => 'select',
        ]);

        $optionNameArray = ['S', 'M', 'L'];
        $optionValuesIdArray = [];
        for ($i = 0; $i < 3; ++$i) {
            $optionValue = OptionValue::create([
                'option_id' => $option->id,
                'name' => $optionNameArray[$i],
            ]);

            $optionValuesIdArray[] = $optionValue->id;
        }

        $product = Product::create([
            'sku' => \Str::random(10),
            'name' => '10TH BIRTHDAY EMOJI AND FRAME BANNER',
            'length' => 10,
            'breadth' => 11,
            'height' => 12,
            'width' => 13,
            'description' => 'SPEEDYORDERS -10th Birthday Emoji and Frame Banner Size 24x18, 36x24, 48x24 and
            48x36, Custom Decor, Personalized, Emoji Backdrop, Handmade Party Supplies, Kids Party favor
            This Banner Sign is the perfect choice of home for your Party decoration. Why not organize
            all the other party supplies around our Party Poster Sign? In case you are looking for an impressive
            party backdrop, this is the perfect fit for your party decorations.',
            'base_price' => 250,
            'quantity' => 100,
            'min_quantity' => 5,
            'subtract_stock' => 1,
            'sort_order' => 1,
            'status' => 1,
            'image' => '1.jpg',
            'trending' => 1,
            'is_featured' => 1,
        ]);

        $imageNameArray = ['1.jpg', '2.jpg', '3.jpg'];

        for ($i = 0; $i < 3; ++$i) {
            $productGallery = ProductGallery::create(
                [
                    'product_id' => $product->id,
                    'image' => $imageNameArray[$i],
                    'order' => $i + 1,
                ]
            );
        }

        for ($i = 1; $i < 3; ++$i) {
            $productCategories = ProductCategory::create([
                'product_id' => $product->id,
                'category_id' => $i,
                'status' => 1,
            ]);
        }

        $productOption = ProductOption::create([
            'product_id' => $product->id,
            'option_id' => $option->id,
            'required' => 1,
        ]);

        $imageNameArray = [];

        $imageNameArray = ['17.png', '16.png', '18.jpg'];

        for ($i = 0; $i < count($optionValuesIdArray); ++$i) {
            ProductOptionValue::create([
                'product_option_id' => $productOption->id,
                'option_id' => $option->id,
                'option_value_id' => $optionValuesIdArray[$i],
                'quantity' => 10,
                'price' => 10 + 5 * $i,
                'price_prefix' => '+',
                'thumbnail' => $imageNameArray[$i],
            ]);
        }

        // for one product 2

        $option = Option::create([
            'name' => 'Color',
            'type' => 'select',
        ]);

        $optionNameArray = []; //change
        $optionNameArray = ['Red', 'Green', 'Blue'];
        $optionValuesIdArray = []; // change
        for ($i = 0; $i < 3; ++$i) {
            $optionValue = OptionValue::create([
                'option_id' => $option->id,
                'name' => $optionNameArray[$i],
            ]);

            $optionValuesIdArray[] = $optionValue->id;
        }

        $product = Product::create([
            'sku' => \Str::random(10),
            'name' => 'AMERICAN FOOTBALL PHOTOBOOTH FRAME SPORTS FOOTBALL PARTY PROPS',
            'length' => 10,
            'breadth' => 11,
            'height' => 12,
            'width' => 13,
            'description' => 'There"s nothing like the thrill of the moment for your upcoming birthday, and this joy is something worth sharing with your loved ones! Birthday parties are happy and heartwarming affairs, and this photo booth is a perfect addition to your party. Have fun!',
            'base_price' => 600,
            'quantity' => 100,
            'min_quantity' => 5,
            'subtract_stock' => 1,
            'sort_order' => 1,
            'status' => 1,
            'image' => '5.jpg',
            'trending' => 1,
            'is_featured' => 1,
        ]);

        $imageNameArray = ['4.jpg', '5.jpg', '6.jpg'];

        for ($i = 0; $i < 3; ++$i) {
            $productGallery = ProductGallery::create(
                [
                    'product_id' => $product->id,
                    'image' => $imageNameArray[$i],
                    'order' => $i + 1,
                ]
            );
        }

        for ($i = 3; $i < 5; ++$i) {
            $productCategories = ProductCategory::create([
                'product_id' => $product->id,
                'category_id' => $i, //change
                'status' => 1,
            ]);
        }

        $productOption = ProductOption::create([
            'product_id' => $product->id,
            'option_id' => $option->id,
            'required' => 1,
        ]);
        $imageNameArray = [];

        $imageNameArray = ['13.png', '14.png', '15.png'];

        for ($i = 0; $i < count($optionValuesIdArray); ++$i) {
            ProductOptionValue::create([
                'product_option_id' => $productOption->id,
                'option_id' => $option->id,
                'option_value_id' => $optionValuesIdArray[$i],
                'quantity' => 10,
                'price' => 10 + 5 * $i,
                'price_prefix' => '+',
                'thumbnail' => $imageNameArray[$i],
            ]);
        }

        // for one product 3

        $option = Option::create([
            'name' => 'Replace Text (HAPPY BIRTHDAY)',
            'type' => 'text',
        ]);

        $product = Product::create([
            'sku' => \Str::random(10),
            'name' => '11TH BIRTHDAY EMOJI AND FRAME BANNER',
            'length' => 10,
            'breadth' => 11,
            'height' => 12,
            'width' => 13,
            'description' => 'SPEEDYORDERS -11th Birthday Emoji and Frame Banner Size 24x18, 36x24, 48x24 and
            48x36, Custom Decor, Personalized, Emoji Backdrop, Handmade Party Supplies, Kids Party favor
            This Banner Sign is the perfect choice of home for your Party decoration. Why not organize
            all the other party supplies around our Party Poster Sign? In case you are looking for an impressive
            party backdrop, this is the perfect fit for your party decorations.',
            'base_price' => 200,
            'quantity' => 100,
            'min_quantity' => 5,
            'subtract_stock' => 1,
            'sort_order' => 1,
            'status' => 1,
            'image' => '1.jpg',
            'trending' => 1,
            'is_featured' => 1,
        ]);

        $imageNameArray = ['1.jpg', '2.jpg', '3.jpg'];

        for ($i = 0; $i < 3; ++$i) {
            $productGallery = ProductGallery::create(
                [
                    'product_id' => $product->id,
                    'image' => $imageNameArray[$i],
                    'order' => $i + 1,
                ]
            );
        }

        $productCategories = ProductCategory::create([
            'product_id' => $product->id,
            'category_id' => 1,
            'status' => 1,
        ]);

        $productOption = ProductOption::create([
            'product_id' => $product->id,
            'option_id' => $option->id,
            'required' => 1,
        ]);

        // for one product 4

        $option = Option::create([
            'name' => 'Size',
            'type' => 'select',
        ]);

        $optionNameArray = []; //change
        $optionNameArray = ['Small', 'Medium', 'Large'];
        $optionValuesIdArray = []; // change
        for ($i = 0; $i < 3; ++$i) {
            $optionValue = OptionValue::create([
                'option_id' => $option->id,
                'name' => $optionNameArray[$i],
            ]);

            $optionValuesIdArray[] = $optionValue->id;
        }

        $product = Product::create([
            'sku' => \Str::random(10),
            'name' => 'CHRISTMAS GIFT BOX STYLE XMAS PHOTO BOOTH PROP CHRISTMAS FRAME',
            'length' => 10,
            'breadth' => 11,
            'height' => 12,
            'width' => 13,
            'description' => 'Christmas is arriving very soon and most of us have started the preparation of this auspicious event. This is a Large Personalized Christmas Gift Box style photo booth prop frame is the best for you on this occasion. Please help us customize your poster performing simple steps in the required selection fields:

                    Size: 36x24 Fits 1-2 people/frame.

                    48x36 Fits 2-3 people/frame.

                    Person size varies, small kids or giant adults, this estimate is for average size person.',
            'base_price' => 100,
            'quantity' => 100,
            'min_quantity' => 5,
            'subtract_stock' => 1,
            'sort_order' => 1,
            'status' => 1,
            'image' => '7.jpg',
            'trending' => 1,
            'is_featured' => 1,
        ]);

        $imageNameArray = ['7.jpg', '8.png', '9.jpg'];

        for ($i = 0; $i < 3; ++$i) {
            $productGallery = ProductGallery::create(
                [
                    'product_id' => $product->id,
                    'image' => $imageNameArray[$i],
                    'order' => $i + 1,
                ]
            );
        }

        $productCategories = ProductCategory::create([
            'product_id' => $product->id,
            'category_id' => 2, //change
            'status' => 1,
        ]);

        $productOption = ProductOption::create([
            'product_id' => $product->id,
            'option_id' => $option->id,
            'required' => 1,
        ]);

        $imageNameArray = [];

        $imageNameArray = ['17.png', '16.png', '18.jpg'];

        for ($i = 0; $i < count($optionValuesIdArray); ++$i) {
            ProductOptionValue::create([
                'product_option_id' => $productOption->id,
                'option_id' => $option->id,
                'option_value_id' => $optionValuesIdArray[$i],
                'quantity' => 10,
                'price' => 10 + 5 * $i,
                'price_prefix' => '+',
                'thumbnail' => $imageNameArray[$i],
            ]);
        }

        // for one product 5

        $option = Option::create([
            'name' => 'Replace Text (The Sharma"s)',
            'type' => 'text',
        ]);

        $product = Product::create([
            'sku' => \Str::random(10),
            'name' => 'DIWALI INDIAN PARTY BANNER POSTER PRINT SIZES 48X36, 48X24, 36X24 AND 24X18',
            'length' => 10,
            'breadth' => 11,
            'height' => 12,
            'width' => 13,
            'description' => 'This Diwali Indian Birthday Party Poster is the perfect choice of home for your Diwali Party decoration in an academic style. Why not organize all the other party supplies around our Diwali Party Banner Sign? In case you are looking for an impressive party backdrop, this is the perfect fit for your Diwali Party decorations',
            'base_price' => 300,
            'quantity' => 100,
            'min_quantity' => 5,
            'subtract_stock' => 1,
            'sort_order' => 1,
            'status' => 1,
            'image' => '10.jpg',
            'trending' => 1,
            'is_featured' => 1,
        ]);

        $imageNameArray = ['10.jpg', '11.jpg', '12.jpg'];

        for ($i = 0; $i < 3; ++$i) {
            $productGallery = ProductGallery::create(
                [
                    'product_id' => $product->id,
                    'image' => $imageNameArray[$i],
                    'order' => $i + 1,
                ]
            );
        }

        $productCategories = ProductCategory::create([
            'product_id' => $product->id,
            'category_id' => 2,
            'status' => 1,
        ]);

        $productOption = ProductOption::create([
            'product_id' => $product->id,
            'option_id' => $option->id,
            'required' => 1,
        ]);

        // factory(Option::class,3)->create()->each(function ($option){
        //     $option->optionValues()->saveMany(factory(OptionValue::class, 2)->make());
        // });

        // factory(Product::class,3)->create()->each(function ($product) {

        //     $product->galleries()->saveMany(factory(ProductGallery::class, 2)->make());

        //     $product->categories()->saveMany(factory(ProductCategory::class, 1)->make());

        //     $product->relatedProducts()->saveMany(factory(ProductRelatedProduct::class,2)->make());

        //     $product->options()->saveMany(factory(ProductOption::class, 1)->make())->each(
        //         function($productOption){
        //             $productOption->optionValues()->saveMany(
        //                 factory(ProductOptionValue::class,1)->create()
        //             );
        //         }
        //     );

        // });
    }
}
