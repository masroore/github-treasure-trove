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
use Log;

class UpdateProductService
{
    public function handle(array $validatedData, $id)
    {
        \DB::beginTransaction();

        try {
            $product = Product::find($id);

            if (isset($validatedData['image'])) {
                $image = $validatedData['image'];
                $image_name = uniqid() . time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/products'), $image_name);
                @unlink(public_path('images/products/' . $product->image));
                $validatedData['image'] = $image_name;
            }

            $validatedData['slug'] = $this->slugify($validatedData['name']);

            $product->update($validatedData);

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

            if (isset($validatedData['categories']) && $validatedData['categories']) {
                $product->categories()->delete();

                // SAVING PRODUCT CATEGORIES RELATIONSHIP
                $insertData = [];
                $time = now();
                foreach ($validatedData['categories'] as $categroy) {
                    $insertData[] = [
                        'category_id'=>$categroy,
                        'product_id'=>$product->id,
                        'status'=>1,
                        'created_at'=>$time,
                        'updated_at'=>$time,
                    ];
                }

                ProductCategory::insert($insertData);
            }

            // HANDLING OPTIONS
            if (isset($validatedData['option']) && \count($validatedData['option']) > 0) {
                $ids = $product->options->pluck('id');
                if (\count($ids) > 0) {
                    ProductOption::whereIn('id', $ids)->delete();
                    ProductOptionValue::whereIn('product_option_id', $ids)->delete();
                }

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
                            Log::info(array("option" => $option));
                            foreach ($option['option_values'] as $counter => $optionValue) {

                                Log::info(array("Option Data" => $option['option_data']));

                                $productOptionData = [
                                    'product_id' => $product->id,
                                    'option_id' => $option['option_data'][$counter][0],
                                    'required' =>
                                        (bool) $validatedData[
                                            'option_required'
                                        ],
                                ];

                                $productOption = ProductOption::create($productOptionData);

                                Log::info(array("Option Values" => $optionValue));

                                foreach ($optionValue as $vaueKey => $item) {

                                    $productOptionValueData = [
                                        'product_option_id' =>
                                            $productOption->id,
                                        'option_id' => $option['option_data'][$counter][0],
                                        'option_value_id' => $item,
                                        'quantity' =>
                                            (isset($option['quantity'][$counter][
                                                $vaueKey
                                            ])) ? $option['quantity'][$counter][
                                                $vaueKey
                                            ] : 0,
                                        'subtract_from_stock' =>
                                            (isset($option['subtract_from_stock'][
                                                $counter
                                            ][$vaueKey])) ? $option['subtract_from_stock'][
                                                $counter
                                            ][$vaueKey] : 0,
                                        'price_prefix' => (isset($option['price_prefix'][$counter][$vaueKey]) && $option['price_prefix'][$counter][$vaueKey] == '+') ? 1: 0,
                                        'price' =>
                                            (isset($option['price'][$counter][
                                                $vaueKey
                                            ])) ? $option['price'][$counter][
                                                $vaueKey
                                            ] :0,
                                    ];

                                    ProductOptionValue::create($productOptionValueData);
                                }
                            }
                            break;*/
                    }
                }
            }

            if (isset($validatedData['delivery_time']) && \count($validatedData['delivery_time']) > 0) {

              //  print_R($product->delivery_time);die;

                if (isset($product->delivery_time) && !empty($product->delivery_time)) {
                    foreach ($product->delivery_time as $deliveryData) {
                        $dt_time = ProductDeliveryTime::find($deliveryData->id);
                        $dt_time->delete();
                    }
                }

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
                if (isset($product->related_products) && !empty($product->related_products)) {
                    $product->related_products->delete();
                }
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

            /*if(isset($validatedData['groups']) && count($validatedData['groups'])>0){
                if($product->groups){
                    ProductGroup::where('product_id', $product->id)->delete();
                }
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

            \DB::commit();

            return true;
        } catch (\Exception $e) {
            dd($e);
            \DB::rollback();

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
