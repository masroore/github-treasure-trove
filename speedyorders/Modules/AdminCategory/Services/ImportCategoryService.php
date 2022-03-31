<?php

namespace Modules\AdminCategory\Services;

use App\Models\Category;
use domDocument;
use Illuminate\Support\Facades\DB;
use Log;

class ImportCategoryService
{
    public function handle(array $validatedData)
    {
        try {
            DB::beginTransaction();

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
            $file = fopen($filename, 'r');
            $all_data = [];

            $count_header = 0;

            while (($data = fgetcsv($file, 2500, ',')) !== false) {
                if ($count_header > 0) {
                    $categoryId = $data[0];
                    $categoryName = $data[1];
                    $categoryParentId = $data[2];
                    $categoryImageUrl = $data[3];
                    $categoryStatus = $data[4];
                    // $categoryDescription = htmlspecialchars_decode($data[5]);

                    /* $doc = new DOMDocument();
                     $doc->loadHTML($categoryDescription);
                     $elements = $doc->getElementsByTagName('img');

                     if(!empty($elements)){
                         foreach($elements as $element) {
                             $categoryDescImageUrl = $element->getAttribute('src');

                             if(isset($categoryDescImageUrl) && $categoryDescImageUrl!=''){
                                 $pathinfodesc = pathinfo($categoryDescImageUrl);
                                 $imagenamedesc = $pathinfodesc['filename'].'.'.$pathinfodesc['extension'];

                                 $desc_image_url = public_path("images/category_description_images/".$imagenamedesc);

                                 @file_put_contents($desc_image_url, @file_get_contents($categoryDescImageUrl));
                             }

                         }
                     }

                     //$categoryDescription = str_replace('');
                     // https://speedyorders.com/image/catalog/2021-Alex/Birthday%20Theme/Favorite%20Pets.jpg

                     print_r($categoryDescription);
                         */

                    $str_random = $this->generateRandomString(3);

                    $imagename = '';
                    if (isset($categoryImageUrl) && '' != $categoryImageUrl) {
                        $pathinfo = pathinfo($categoryImageUrl);
                        $imagename = $pathinfo['filename'] . '.' . $pathinfo['extension'];

                        $image_url = public_path('images/categories/' . $imagename);

                        @file_put_contents($image_url, @file_get_contents($categoryImageUrl));
                    }

                    $category = new Category();
                    $category->id = $categoryId;
                    $category->category_id = $categoryParentId;
                    $category->is_featured = 0;
                    $category->name = $categoryName;
                    $category->image = $imagename;
                    $category->slug = str_replace(' ', '-', strtolower($categoryName)) . '-' . $str_random;
                    $category->status = $categoryStatus;
                    $category->save();
                }

                $count_header++;
            }

            DB::commit();

            return true;
        } catch (\Exception $e) {
            Log::info('Error' . $e->getMessage());
            Log::info('Line Number' . $e->getLine());
            DB::rollback();

            return false;
        }
    }

    public function generateRandomString($length = 3)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = \strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}
