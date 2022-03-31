<?php

namespace Modules\AdminProduct\Services;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductDeliveryTime;
use App\Models\ProductGallery;
use App\Models\ProductGroup;
use App\Models\ProductOption;
use App\Models\ProductOptionValue;
use App\Models\ProductRelatedProduct;
use Illuminate\Support\Facades\DB;

class CreateProductService
{
    public function handleGeneralInformation(array $validatedData)
    {
        try {
            DB::beginTransaction();

            if (isset($validatedData['image'])) {
                $image = $validatedData['image'];
                $imageName =
                    uniqid() .
                    time() .
                    '.' .
                    $image->getClientOriginalExtension();
                $image->move(public_path('images/products'), $imageName);
                $validatedData['image'] = $imageName;
            }

            $validatedData['slug'] = $this->slugify($validatedData['name']);

            $product = Product::create($validatedData);

            if (isset($validatedData['galleryId'])) {
                $galleryId = rtrim($validatedData['galleryId'], ',');

                $galleryId = explode(',', $galleryId);
                $productGallery = ProductGallery::whereIn('id', $galleryId)->get();
                // SAVING PRODUCT IMAGES
                foreach ($productGallery ?? [] as $key => $gallery) {
                    $gallery->update([
                        'product_id' => $product->id,
                    ]);
                }
            }

            if (isset($validatedData['categories'])) {
                // SAVING PRODUCT CATEGORIES RELATIONSHIP
                $insertData = [];
                $time = now();
                foreach ($validatedData['categories'] as $categroy) {
                    $insertData[] = [
                        'category_id' => $categroy,
                        'product_id' => $product->id,
                        'status' => 1,
                        'created_at' => $time,
                        'updated_at' => $time,
                    ];
                }

                ProductCategory::insert($insertData);
            }

            // HANDLING OPTIONS
            if (
                isset($validatedData['option']) &&
                \count($validatedData['option']) > 0
            ) {
                foreach ($validatedData['option'] as $optionKey => $option) {
                    switch ($optionKey) {
                        case 'input':
                            foreach ($option as $key => $optionValue) {
                                $productOption = ProductOption::create([
                                    'product_id' => $product->id,
                                    'option_id' => $key,
                                    'required' =>$validatedData['option']['required'][$key],
                                ]);

                                ProductOptionValue::create([
                                    'product_option_id' => $productOption->id,
                                    'option_id' => $key,
                                    'input_value' => $optionValue,
                                ]);
                            }
                            break;

                        /*case 'select':
                            foreach ($option['option_values'] as $counter => $optionValue) {
                                $productOption = ProductOption::create([
                                    'product_id' => $product->id,
                                    'option_id' => $option['option_data'][$counter][0],
                                    'required' =>
                                        (bool) $validatedData[
                                            'option_required'
                                        ],
                                ]);

                                foreach ($optionValue as $vaueKey => $item) {
                                    ProductOptionValue::create([
                                        'product_option_id' =>
                                            $productOption->id,
                                        'option_id' => $option['option_data'][$counter][0],
                                        'option_value_id' => $item,
                                        'quantity' =>
                                            $option['quantity'][$counter][
                                                $vaueKey
                                            ],
                                        'subtract_from_stock' =>
                                            $option['subtract_from_stock'][
                                                $counter
                                            ][$vaueKey],
                                        'price_prefix' =>
                                            $option['price_prefix'][$counter][
                                                $vaueKey
                                            ],
                                        'price' =>
                                            $option['price'][$counter][
                                                $vaueKey
                                            ],
                                    ]);
                                }
                            }
                            break;*/
                    }
                }
            }

            if (isset($validatedData['delivery_time']) && \count($validatedData['delivery_time']) > 0) {
                $insertDeliveryTimeData = [];
                $time = now();
                foreach ($validatedData['delivery_time'] as $rp) {
                    $insertDeliveryTimeData[] = [
                        'products_id'=>$product->id,
                        'shipping_delivery_times_id'=>$rp,
                        'shipping_zone_groups_id'=>$validatedData['shipping_zone_groups_id'],
                        'shipping_packages_id'=>$validatedData['shipping_packages_id'],
                        'created_at' => $time,
                        'updated_at' => $time,
                    ];
                }

                ProductDeliveryTime::insert($insertDeliveryTimeData);
            }

            if (isset($validatedData['related_products']) && \count($validatedData['related_products']) > 0) {
                $insertRelatedProductData = [];
                $time = now();
                foreach ($validatedData['related_products'] as $rp) {
                    $insertRelatedProductData[] = [
                        'product_id'=>$product->id,
                        'related_product_id'=>$rp,
                        'created_at' => $time,
                        'updated_at' => $time,
                    ];
                }

                ProductRelatedProduct::insert($insertRelatedProductData);
            }

            /*if(count($validatedData['groups'])>0){
                $insertGroupData = [];
                $time = now();
                foreach($validatedData['groups'] as $group){
                    $insertGroupData[] =[
                        'product_id'=>$product->id,
                        'group_id'=>$group
                    ];
                }

                ProductGroup::insert($insertGroupData);
            }*/

            DB::commit();

            return true;
        } catch (\Exception $e) {
            //TODO:
            // REMOVE IMAGE FROM FOLDER
            dd($e);
            DB::rollback();

            return false;
        }
    }

    public function slugify($text, string $divider = '-')
    {

            // replace non letter or digits by divider
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, $divider);

        // remove duplicate divider
        $text = preg_replace('~-+~', $divider, $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            $text = 'n-a';
        }

        return $text;
    }
}
