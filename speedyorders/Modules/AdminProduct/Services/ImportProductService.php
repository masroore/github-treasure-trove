<?php

namespace Modules\AdminProduct\Services;

use App\Models\Option;
use App\Models\OptionValue;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductOption;
use App\Models\ProductOptionValue;
use App\Models\ProductRelatedProduct;
use Exception;
use Illuminate\Support\Facades\DB;
use Log;

class ImportProductService
{
    public function handle(array $validatedData)
    {
        try {

          //  DB::beginTransaction();

            $fileName = '';
            if (isset($validatedData['file_name'])) {
                $file_name = $validatedData['file_name'];
                $fileName =
                    uniqid() .
                    time() .
                    '.' .
                    $file_name->getClientOriginalExtension();
                $file_name->move(public_path('images/products'), $fileName);
                $validatedData['file_name'] = $fileName;
            }

            // Now parse the csv and store all values in DB
            $filename = public_path('images/products/' . $fileName);
            $file = fopen($filename, 'rb');
            $all_data = [];

            $count_header = 0;

            while (($data = fgetcsv($file, 10000, ',')) !== false) {
                if ($count_header > 0 && 20 == \count($data)) {
                    $productImageUrl = (isset($data[19])) ? $data[19] : '';

                    // to upload product image

                    $random_string = $this->generateRandomString(10);

                    $imagename = '';
                    if (isset($productImageUrl) && '' != $productImageUrl) {
                        $pathinfo = pathinfo($productImageUrl);
                        $imagename = 'Product_' . $random_string . '.' . $pathinfo['extension'];
                        $image_url = public_path('images/products/' . $imagename);
                        @file_put_contents($image_url, @file_get_contents($productImageUrl));
                    }

                    $productId = $data[0];
                    $product_name = $data[1];
                    $product_description = (isset($data[2])) ? $data[2] : '';
                    $meta_title = $data[3];
                    $meta_description = $data[4];
                    $meta_keywords = $data[5];
                    $sku = (isset($data[6])) ? $data[6] : '';
                    $product_height = (isset($data[7])) ? $data[7] : 0;
                    $product_width = (isset($data[8])) ? $data[8] : 0;
                    $product_length = (isset($data[9])) ? $data[9] : 0;
                    $base_price = $data[10];
                    $sale_price = $data[11];
                    $product_qty = $data[12];
                    $public_status = $data[13];
                    $is_featured = $data[14];
                    $return_policy_days = $data[15];

                    $category_ids = explode(',', $data[16]);

                    $related_products = explode(',', $data[17]);
                    $options = explode(',', $data[18]);

                    // check if product already exists
                    $product_Data = Product::where('name', $product_name)->where('sku', $sku)->first();
                    if (!empty($product_Data)) {
                        $product_id = $product_Data['id'];
                    } else {
                        $product = new Product();
                        $product->id = $productId;
                        $product->sku = $sku;
                        $product->name = $product_name;
                        $product->length = $product_length;
                        $product->height = $product_height;
                        $product->width = $product_width;
                        $product->description = $product_description;
                        $product->base_price = $base_price;
                        $product->sale_price = $sale_price;
                        $product->quantity = $product_qty;
                        $product->is_featured = ('Yes' == $is_featured) ? 1 : 0;
                        $product->status = ('Yes' == $public_status) ? 1 : 0;
                        $product->meta_title = $meta_title;
                        $product->meta_description = $meta_description;
                        $product->meta_keywords = $meta_keywords;
                        $product->image = $imagename;
                        $product->return_policy_days = (isset($return_policy_days) && '' != $return_policy_days) ? $return_policy_days : 0;
                        $product->created_at = now();
                        $product->save();

                        $product_id = $product->id;
                    }

                    if (isset($options[0])) {
                        $exploded_options = explode(';', $options[0]);

                        if (!empty($exploded_options)) {
                            foreach ($exploded_options as $optionData) {
                                $optionData_exploded = explode('::', $optionData);

                                $name = $inputtext = $price_prefix = '';
                                $quantity = $price = $subtract_stock = 0;

                                // check if option and there type is available thenonly add it for the product
                                $option_id = '';
                                if (isset($optionData_exploded[0]) && '' != $optionData_exploded[0] && isset($optionData_exploded[1]) && '' != $optionData_exploded[1]) {
                                    $option_name = trim($optionData_exploded[0]);
                                    $option_type = (isset($optionData_exploded[1]) && 'text' == trim($optionData_exploded[1])) ? 'input' : 'select';

                                    $option_data = Option::where('name', $option_name)->where('type', $option_type)->first();

                                    if (isset($option_data['id']) && '' != $option_data['id']) {
                                        $option_id = $option_data['id'];
                                    } else {
                                        $newoption = new Option();
                                        $newoption->name = $option_name;
                                        $newoption->type = $option_type;
                                        $newoption->save();

                                        $option_id = $newoption->id;
                                    }
                                }

                                // check if product option value available or not
                                $optionvalue_id = 0;
                                if (isset($optionData_exploded[2]) && '' != $optionData_exploded[2] && isset($option_id) && '' != $option_id) {
                                    $productOptionValues = explode('~', $optionData_exploded[2]);

                                    Log::info("Product($product_id) Option Values : " . json_encode($productOptionValues));

                                    // values for product option values
                                    if ('select' == $option_type) {
                                        $name = trim($productOptionValues[0]);
                                        $quantity = (isset($productOptionValues[1])) ? $productOptionValues[1] : 0;
                                        $subtract_stock = (isset($productOptionValues[2])) ? $productOptionValues[2] : '';
                                        $price_prefix = (isset($productOptionValues[3])) ? $productOptionValues[3] : '';
                                        $price = (isset($productOptionValues[4])) ? $productOptionValues[4] : 0;
                                    } else {
                                        $inputtext = trim($productOptionValues[0]);
                                    }

                                    $optionVal_data = OptionValue::where('name', trim($name))->first();
                                    if (!empty($optionVal_data)) {
                                        $optionvalue_id = $optionVal_data['id'];
                                    } else {
                                        $newoptionvalue = new OptionValue();
                                        $newoptionvalue->option_id = $option_id;
                                        $newoptionvalue->name = trim($name);
                                        $newoptionvalue->save();

                                        $optionvalue_id = $newoptionvalue->id;
                                    }
                                }

                                // Now add new option or added option for the product
                                $productOption_id = 0;
                                if (isset($option_id) && '' != $option_id && isset($optionvalue_id)) {
                                    $productoption_data = ProductOption::where('product_id', $product_id)->where('option_id', $option_id)->first();
                                    if (!empty($productoption_data)) {
                                        $productOption_id = $productoption_data['id'];
                                    } else {
                                        $productOption = new ProductOption();
                                        $productOption->product_id = $product_id;
                                        $productOption->option_id = $option_id;
                                        $productOption->save();

                                        $productOption_id = $productOption->id;
                                    }

                                    // Now check for the product option value data and insert if not available
                                    $productOptionValue_data = ProductOptionValue::where('product_option_id', $productOption_id)->where('option_value_id', $optionvalue_id)->where('option_id', $option_id)->first();

                                    if (!empty($productOptionValue_data)) {
                                        $productOptionValue_id = $productOptionValue_data['id'];
                                    } else {
                                        $productOptionValue = new ProductOptionValue();
                                        $productOptionValue->product_option_id = $productOption_id;
                                        $productOptionValue->option_value_id = $optionvalue_id;
                                        $productOptionValue->option_id = $option_id;
                                        $productOptionValue->quantity = $quantity;
                                        $productOptionValue->subtract_from_stock = (isset($subtract_stock) && '' != $subtract_stock) ? $subtract_stock : 0;
                                        $productOptionValue->price = $price;
                                        $productOptionValue->price_prefix = $price_prefix;
                                        $productOptionValue->input_value = $inputtext;
                                        $productOptionValue->status = 1;
                                        $productOptionValue->save();

                                        $productOptionValue_id = $productOptionValue->id;
                                    }
                                }
                            }
                        }
                    }

                    if (!empty($category_ids)) {
                        foreach ($category_ids as $category_id) {
                            $product_category_Data = ProductCategory::where('product_id', $product_id)->where('category_id', $category_id)->first();
                            if (empty($product_category_Data) && '' != $category_id) {
                                $productCategory = new ProductCategory();
                                $productCategory->product_id = $product_id;
                                $productCategory->category_id = $category_id;
                                $productCategory->save();
                            }
                        }
                    }

                    if (!empty($related_products)) {
                        foreach ($related_products as $related_product_id) {
                            $related_product_Data = ProductRelatedProduct::where('product_id', $product_id)->where('related_product_id', $related_product_id)->first();
                            if (empty($related_product_Data) && '' != $related_product_id) {
                                $relatedProductData = new ProductRelatedProduct();
                                $relatedProductData->product_id = $product_id;
                                $relatedProductData->related_product_id = $related_product_id;
                                $relatedProductData->save();
                            }
                        }
                    }
                }

                ++$count_header;
            }
            //  DB::commit();

            return true;
        } catch (Exception $e) {
            Log::info('Error' . $e->getMessage());
            Log::info('Line Number' . $e->getLine());
            //DB::rollback();
            return false;
        }
    }

    public function generateRandomString($length = 3)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = \strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; ++$i) {
            $randomString .= $characters[mt_rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}
