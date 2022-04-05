<?php

namespace App\Http\Controllers;

use App\VariantImages;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class DeleteImageController extends Controller
{
    public function deleteimg1(Request $request, $id)
    {
        $del = VariantImages::findorfail($id);

        $path = public_path() . '/images/variantimages/';

        if (file_exists($path . '/' . $request->getval)) {
            unlink($path . '/' . $request->getval);
        }

        $del->image1 = null;

        $del->save();

        return 'Success';
    }

    public function deleteimg2(Request $request, $id)
    {
        $del = VariantImages::findorfail($id);

        $path = public_path() . '/images/variantimages/';

        if (file_exists($path . '/' . $request->getval)) {
            unlink($path . '/' . $request->getval);
        }

        if (file_exists('../public/variantimages/hoverthumbnail' . $request->getval)) {
            unlink(public_path() . '/variantimages/hoverthumbnail/' . $request->getval);
        }

        $del->image2 = null;

        $del->save();

        return 'Success';
    }

    public function deleteimg3(Request $request, $id)
    {
        $del = VariantImages::findorfail($id);

        $path = public_path() . '/images/variantimages/';

        if (file_exists($path . '/' . $request->getval)) {
            unlink($path . '/' . $request->getval);
        }

        $del->image3 = null;

        $del->save();

        return 'Success';
    }

    public function deleteimg4(Request $request, $id)
    {
        $del = VariantImages::findorfail($id);

        $path = public_path() . '/images/variantimages/';

        if (file_exists($path . '/' . $request->getval)) {
            unlink($path . '/' . $request->getval);
        }

        $del->image4 = null;

        $del->save();

        return 'Success';
    }

    public function deleteimg5(Request $request, $id)
    {
        $del = VariantImages::findorfail($id);

        $path = public_path() . '/images/variantimages/';

        if (file_exists($path . '/' . $request->getval)) {
            unlink($path . '/' . $request->getval);
        }

        $del->image5 = null;

        $del->save();

        return 'Success';
    }

    public function deleteimg6(Request $request, $id)
    {
        $del = VariantImages::findorfail($id);
        $path = public_path() . '/images/variantimages/';

        if (file_exists($path . '/' . $request->getval)) {
            unlink($path . '/' . $request->getval);
        }

        $del->image6 = null;

        $del->save();

        return 'Success';
    }

    public function setdef(Request $request, $id)
    {

        //if($request->ajax()){
        $findrow = VariantImages::where('var_id', $id)->first();

        $thumbpath = public_path() . '/variantimages/thumbnails';

        if (file_exists($thumbpath . '/' . $findrow->main_image)) {
            unlink($thumbpath . '/' . $findrow->main_image);
        }

        /** Get requested image and convert it to thumbnails */
        $img = Image::make(@file_get_contents('../public/variantimages/' . $request->defimage));

        $img->resize(400, 400, function ($constraint): void {
            $constraint->aspectRatio();
        });

        $img->save($thumbpath . '/' . $request->defimage);

        $findrow->main_image = $request->defimage;

        $findrow->save();

        return 'Success';
        //}
    }
}
