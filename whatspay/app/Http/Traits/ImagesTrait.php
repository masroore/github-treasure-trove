<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

trait ImagesTrait
{
//    /**Save Images Copies In different Sizes
//     *
//     * @param $img_name
//     * @return string|string[]
//     */
//    public function saveImagesCopies($img_name)
//    {
//        $name = pathinfo(public_path($img_name),PATHINFO_FILENAME);
//        $image = Image::make(public_path($img_name))->resize(130, 110)->encode('webp');
//        Storage::disk('local')->put('images/'.$name.'-S.webp',$image);
//        $image = Image::make(public_path($img_name))->fit(370, 250)->encode('webp');
//        Storage::disk('local')->put('images/'.$name.'-M.webp',$image);
//        $image = Image::make(public_path($img_name))->fit(700, 450)->encode('webp');
//        Storage::disk('local')->put('images/'.$name.'-L.webp',$image);
//        $image = Image::make(public_path($img_name))->fit(9030, 730)->encode('webp');
//        Storage::disk('local')->put('images/'.$name.'-XL.webp' ,$image);
//        return 'images/'.$name;
//    }

    /**
     * @param $img_name
     */
    public function saveImagesCopies($img_name): string
    {
        //dd($img_name);
        $img_instance = Image::make(public_path($img_name))->encode('webp', 60);
        $name = pathinfo(public_path($img_name), \PATHINFO_FILENAME);
        $image = Image::make(public_path($img_name))->resize(130, 110)->encode('webp');
        Storage::disk('local')->put('images/' . $name . '-S.webp', $image);
        $image = Image::make(public_path($img_name))->resize(370, 260)->encode('webp');
        Storage::disk('local')->put('images/' . $name . '-M.webp', $image);
        $image = Image::make(public_path($img_name))->resize(670, 440)->encode('webp');
        Storage::disk('local')->put('images/' . $name . '-L.webp', $image);

        $img_instance->resize(null, 500, function ($constraint): void {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        Storage::disk('local')->put('images/' . $name . '-XL.webp', $img_instance);

        return 'images/' . $name;
    }

    /**
     * @param $img_name
     */
    public function saveImagesCopiesWithoutLarge($img_name): string
    {
        $name = pathinfo(public_path($img_name), \PATHINFO_FILENAME);
        $image = Image::make(public_path($img_name))->resize(130, 105)->encode('webp');
        Storage::disk('local')->put('images/' . $name . '-S.webp', $image);
        $image = Image::make(public_path($img_name))->resize(400, 300)->encode('webp');
        Storage::disk('local')->put('images/' . $name . '-M.webp', $image);
        $image = Image::make(public_path($img_name))->encode('webp');
        Storage::disk('local')->put('images/' . $name . '-ORG.webp', $image);

        return 'images/' . $name;
    }
}
