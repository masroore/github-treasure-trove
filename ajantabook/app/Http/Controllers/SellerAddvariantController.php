<?php

namespace App\Http\Controllers;

use App\AddSubVariant;
use App\Mail\ProductStockNotifications;
use App\Product;
use App\ProductAttributes;
use App\ProductNotify;
use App\ProductValues;
use App\VariantImages;
use DB;
use Exception;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Image;

class SellerAddvariantController extends Controller
{
    public function getIndex($id)
    {
        $findpro = Product::findorfail($id);

        return view('seller.productvariant.subvar', compact('findpro'));
    }

    public function post(Request $request, $id)
    {
        $request->validate(['main_attr_id' => 'required', 'main_attr_value' => 'required', 'image1' => 'required'], ['main_attr_id.required' => 'Please select an option', 'main_attr_value.required' => 'Please select a value', 'image1.required' => 'Atleast one image is required']);

        $input = $request->all();

        $array2 = AddSubVariant::where('pro_id', $id)->get();

        foreach ($array2 as $key => $value) {
            $array1 = $value->main_attr_value;

            $test = $input['main_attr_value'];

            $conversion_rate = array_diff($array1, $test);

            if (null == $conversion_rate) {
                notify()->warning(__('Variant already exist ! Kindly Update that'));

                return back();
            }
            foreach ($conversion_rate as $e => $new) {
                if (0 == $new) {
                    notify()->warning(__('Variant already exist ! Kindly Update that'));

                    return back();
                }
            }
        }

        $test = new AddSubVariant();
        $input['pro_id'] = $id;
        //Getting All Def
        $all_def = AddSubVariant::where('def', '=', 1)->where('pro_id', '=', $id)->get();

        if (isset($request->def)) {

            //Updating Current Def
            foreach ($all_def as $value) {
                $remove_def = AddSubVariant::where('id', '=', $value->id)
                    ->update(['def' => 0]);
            }

            $input['def'] = 1;
        } else {
            if ($all_def->count() < 1) {
                notify()->warning(__('Atleast one variant should be set to default !'));

                return back();
            }

            $input['def'] = 0;
        }

        $test->create($input);

        $lastid = AddSubVariant::orderBy('id', 'desc')->first()->id;

        $varimage = new VariantImages();

        $path = public_path() . '/variantimages/';
        $thumbpath = public_path() . '/variantimages/thumbnails/';
        $hoverthumbpath = public_path() . '/variantimages/hoverthumbnail/';

        File::makeDirectory($path, $mode = 0777, true, true);
        File::makeDirectory($thumbpath, $mode = 0777, true, true);
        File::makeDirectory($hoverthumbpath, $mode = 0777, true, true);

        if ($file = $request->file('image1')) {
            $request->validate([
                'image1' => 'mimes:png,jpg,jpeg,gif|max:1024',
            ]);

            $name = 'variant_' . time() . str_random(10) . '.' . $file->getClientOriginalExtension();
            $img = Image::make($file);

            $img->save($path . '/' . $name, 95);
            $varimage->image1 = $name;

            $thumb = $name;

            $img->resize(300, 300, function ($constraint): void {
                $constraint->aspectRatio();
            });

            $img->save($thumbpath . '/' . $thumb, 95);

            $varimage->main_image = $name;
        }

        if ($file = $request->file('image2')) {
            $request->validate([
                'image2' => 'mimes:png,jpg,jpeg,gif|max:1024',
            ]);

            $name = 'variant_' . time() . str_random(10) . '.' . $file->getClientOriginalExtension();
            $img = Image::make($file);

            $img->save($path . '/' . $name, 95);
            $varimage->image2 = $name;

            $hoverthumb = $name;

            $img->resize(300, 300, function ($constraint): void {
                $constraint->aspectRatio();
            });

            $img->save($hoverthumbpath . '/' . $hoverthumb, 95);
        }

        if ($file = $request->file('image3')) {
            $request->validate([
                'image3' => 'mimes:png,jpg,jpeg,gif|max:1024',
            ]);

            $name = 'variant_' . time() . str_random(10) . '.' . $file->getClientOriginalExtension();
            $img = Image::make($file);

            $img->save($path . '/' . $name, 95);
            $varimage->image3 = $name;
        }

        if ($file = $request->file('image4')) {
            $request->validate([
                'image4' => 'mimes:png,jpg,jpeg,gif|max:1024',
            ]);

            $name = 'variant_' . time() . str_random(10) . '.' . $file->getClientOriginalExtension();
            $img = Image::make($file);

            $img->save($path . '/' . $name, 95);
            $varimage->image4 = $name;
        }

        if ($file = $request->file('image5')) {
            $request->validate([
                'image5' => 'mimes:png,jpg,jpeg,gif|max:1024',
            ]);

            $name = 'variant_' . time() . str_random(10) . '.' . $file->getClientOriginalExtension();
            $img = Image::make($file);

            $img->save($path . '/' . $name, 95);
            $varimage->image5 = $name;
        }

        if ($file = $request->file('image6')) {
            $request->validate([
                'image6' => 'mimes:png,jpg,jpeg,gif|max:1024',
            ]);

            $name = 'variant_' . time() . str_random(10) . '.' . $file->getClientOriginalExtension();
            $img = Image::make($file);

            $img->save($path . '/' . $name, 95);
            $varimage->image6 = $name;
        }

        $varimage->var_id = $lastid;

        $varimage->save();

        notify()->success('Variant Linked Successfully !');

        return redirect()->route('seller.add.var', $id);
    }

    public function edit($id)
    {
        $vars = AddSubVariant::findorfail($id);

        return view('seller.productvariant.edit', compact('vars'));
    }

    public function delete($id)
    {
        $vars = AddSubVariant::findorfail($id);

        if (1 != $vars->def) {
            if ($vars->variantimages) {
                // Delete Variant Images first

                // Deleting Main and Hover Image

                if (null != $vars->variantimages->main_image && file_exists('../public/variantimages/thumbnails/' . $vars->variantimages->main_image)) {
                    unlink(public_path() . '/variantimages/thumbnails/' . $vars->variantimages->main_image);
                }

                if (null != $vars->variantimages->image2 && file_exists('../public/variantimages/hoverthumbnail' . $vars->variantimages->image2)) {
                    unlink(public_path() . '/variantimages/hoverthumbnail/' . $vars->variantimages->image2);
                }

                if (null != $vars->variantimages->image1 && file_exists(public_path() . '/variantimages/' . $vars->variantimages->image1)) {
                    unlink(public_path() . '/variantimages/' . $vars->variantimages->image1);
                }

                if (null != $vars->variantimages->image2 && file_exists(public_path() . '/variantimages/' . $vars->variantimages->image2)) {
                    unlink(public_path() . '/variantimages/' . $vars->variantimages->image2);
                }

                if (null != $vars->variantimages->image3 && file_exists(public_path() . '/variantimages/' . $vars->variantimages->image3)) {
                    unlink(public_path() . '/variantimages/' . $vars->variantimages->image3);
                }

                if (null != $vars->variantimages->image4 && file_exists(public_path() . '/variantimages/' . $vars->variantimages->image4)) {
                    unlink(public_path() . '/variantimages/' . $vars->variantimages->image4);
                }

                if (null != $vars->variantimages->image5 && file_exists(public_path() . '/variantimages/' . $vars->variantimages->image5)) {
                    unlink(public_path() . '/variantimages/' . $vars->variantimages->image5);
                }

                if (null != $vars->variantimages->image6 && file_exists(public_path() . '/variantimages/' . $vars->variantimages->image6)) {
                    unlink(public_path() . '/variantimages/' . $vars->variantimages->image6);
                }
                // End
                $vars->variantimages->delete();
            }

            $vars->delete();
        } else {
            notify()->error(__('Default variant cannot be deleted !'));

            return back();
        }

        notify()->success(__('Variant has been Deleted !'));

        return back();
    }

    public function update(Request $request, $id)
    {
        $request->validate(['min_order_qty' => 'numeric|min:1'], ['min_order_qty.min' => 'Minimum order quantity must be atleast 1']);

        $vars = AddSubVariant::find($id);

        if (!$vars) {
            notify()->error('Product variant not found !');

            return back();
        }

        $array2 = AddSubVariant::where('pro_id', $vars->pro_id)
            ->get();
        $all_def = AddSubVariant::where('def', '=', 1)->where('pro_id', $vars->pro_id)
            ->get();
        $all_def2 = AddSubVariant::where('pro_id', $vars->pro_id)
            ->get();

        if ($all_def2->count() < 1) {
            notify()->warning(__('Atleast one value should be set to default !'));

            return back();
        }

        $varimage = VariantImages::where('var_id', $id)->first();

        if (!$varimage) {
            $varimage = new VariantImages();
            $varimage->var_id = $vars->id;
        }

        $path = public_path() . '/variantimages';

        $thumbpath = public_path() . '/variantimages/thumbnails/';

        if (null != $request->stock) {
            $getusers = ProductNotify::select('email')->where('var_id', '=', $id)->get();

            if (isset($getusers)) {
                $proname = $vars->products->name;

                $msg2 = __('Buy Now Before stock goes again !');

                $getusers->each(function ($user) use ($vars, $proname, $msg2): void {
                    try {
                        Mail::to($user->email)->send(new ProductStockNotifications($vars, $msg2, $proname));
                        DB::table('product_stock_subscription')->where('email', '=', $user->email)->delete();
                    } catch (Exception $e) {
                        Log::error('Failed to sent product stock mail');
                    }
                });
            }
        }

        if ($file = $request->file('image1')) {
            $request->validate([
                'image1' => 'mimes:png,jpg,jpeg',
            ]);

            $name = 'variant_' . time() . str_random(10) . '.' . $file->getClientOriginalExtension();
            $img = Image::make($file);

            $img->save($path . '/' . $name, 95);

            if (null != $varimage->image1 && file_exists(public_path() . '/variantimages/' . $varimage->image1)) {
                unlink(public_path() . '/variantimages/' . $varimage->image1);
            }

            if ($varimage->image1 == $varimage->main_image) {
                if (null != $varimage->main_image && file_exists($thumbpath . '/' . $varimage->main_image)) {
                    unlink($thumbpath . '/' . $varimage->main_image);
                }

                $thumb = $name;

                $img->resize(300, 300, function ($constraint): void {
                    $constraint->aspectRatio();
                });

                $img->save($thumbpath . '/' . $thumb, 95);

                $varimage->main_image = $thumb;
            }

            $varimage->image1 = $name;
        }

        if ($file = $request->file('image2')) {
            $request->validate([
                'image2' => 'mimes:png,jpg,jpeg|max:2024',
            ]);

            $name = 'variant_' . time() . str_random(10) . '.' . $file->getClientOriginalExtension();
            $img = Image::make($file);

            $img->save($path . '/' . $name, 95);

            if (null != $varimage->image2 && file_exists(public_path() . '/variantimages/' . $varimage->image2)) {
                unlink(public_path() . '/variantimages/' . $varimage->image2);
            }

            if ($varimage->image2 == $varimage->main_image) {
                if ('' != $varimage->main_image && file_exists($thumbpath . '/' . $varimage->main_image)) {
                    unlink($thumbpath . '/' . $varimage->main_image);
                }

                $thumb = $name;

                $img->resize(300, 300, function ($constraint): void {
                    $constraint->aspectRatio();
                });

                $img->save($thumbpath . '/' . $thumb, 95);

                $varimage->main_image = $thumb;
            }

            $varimage->image2 = $name;

            // Storing Second thumbnail for Hover ONLY FOR IMAGE 2

            if ('' != $varimage->image2 && file_exists(public_path() . '/variantimages/hoverthumbnail/' . $varimage->image2)) {
                unlink(public_path() . '/variantimages/hoverthumbnail/' . $varimage->image2);
            }

            $hoverthumb = $name;

            $img->resize(300, 300, function ($constraint): void {
                $constraint->aspectRatio();
            });

            $img->save($thumbpath . '/' . $hoverthumb, 95);
        }

        if ($file = $request->file('image3')) {
            $request->validate([
                'image3' => 'mimes:png,jpg,jpeg|max:2024',
            ]);

            $name = 'variant_' . time() . str_random(10) . '.' . $file->getClientOriginalExtension();
            $img = Image::make($file);

            $img->save($path . '/' . $name, 95);

            if (null != $varimage->image3 && file_exists(public_path() . '/variantimages/' . $varimage->image3)) {
                unlink(public_path() . '/variantimages/' . $varimage->image3);
            }

            if ($varimage->image3 == $varimage->main_image) {
                if ('' != $varimage->main_image && file_exists($thumbpath . '/' . $varimage->main_image)) {
                    unlink($thumbpath . '/' . $varimage->main_image);
                }

                $thumb = $name;

                $img->resize(300, 300, function ($constraint): void {
                    $constraint->aspectRatio();
                });

                $img->save($thumbpath . '/' . $thumb, 95);

                $varimage->main_image = $thumb;
            }

            $varimage->image3 = $name;
        }

        if ($file = $request->file('image4')) {
            $request->validate([
                'image4' => 'mimes:png,jpg,jpeg|max:2024',
            ]);

            $name = 'variant_' . time() . str_random(10) . '.' . $file->getClientOriginalExtension();
            $img = Image::make($file);

            $img->save($path . '/' . $name, 95);

            if (null != $varimage->image4 && file_exists(public_path() . '/variantimages/' . $varimage->image4)) {
                unlink(public_path() . '/variantimages/' . $varimage->image4);
            }

            if ($varimage->image4 == $varimage->main_image) {
                if ('' != $varimage->main_image && file_exists($thumbpath . '/' . $varimage->main_image)) {
                    unlink($thumbpath . '/' . $varimage->main_image);
                }

                $thumb = $name;

                $img->resize(300, 300, function ($constraint): void {
                    $constraint->aspectRatio();
                });

                $img->save($thumbpath . '/' . $thumb, 95);

                $varimage->main_image = $thumb;
            }

            $varimage->image4 = $name;
        }

        if ($file = $request->file('image5')) {
            $request->validate([
                'image5' => 'mimes:png,jpg,jpeg|max:2024',
            ]);

            $name = 'variant_' . time() . str_random(10) . '.' . $file->getClientOriginalExtension();
            $img = Image::make($file);

            $img->save($path . '/' . $name, 95);

            if (null != $varimage->image5 && file_exists(public_path() . '/variantimages/' . $varimage->image5)) {
                unlink(public_path() . '/variantimages/' . $varimage->image5);
            }

            if ($varimage->image5 == $varimage->main_image) {
                if ('' != $varimage->main_image && file_exists($thumbpath . '/' . $varimage->main_image)) {
                    unlink($thumbpath . '/' . $varimage->main_image);
                }

                $thumb = $name;

                $img->resize(300, 300, function ($constraint): void {
                    $constraint->aspectRatio();
                });

                $img->save($thumbpath . '/' . $thumb, 95);

                $varimage->main_image = $thumb;
            }

            $varimage->image5 = $name;
        }

        if ($file = $request->file('image6')) {
            $request->validate([
                'image6' => 'mimes:png,jpg,jpeg|max:2024',
            ]);

            $name = 'variant_' . time() . str_random(10) . '.' . $file->getClientOriginalExtension();
            $img = Image::make($file);

            $img->save($path . '/' . $name, 95);

            if (null != $varimage->image6 && file_exists(public_path() . '/variantimages/' . $varimage->image6)) {
                unlink(public_path() . '/variantimages/' . $varimage->image6);
            }

            if ($varimage->image6 == $varimage->main_image) {
                if ('' != $varimage->main_image && file_exists($thumbpath . '/' . $varimage->main_image)) {
                    unlink($thumbpath . '/' . $varimage->main_image);
                }

                $thumb = $name;

                $img->resize(300, 300, function ($constraint): void {
                    $constraint->aspectRatio();
                });

                $img->save($thumbpath . '/' . $thumb, 95);

                $varimage->main_image = $thumb;
            }

            $varimage->image6 = $name;
        }

        $varimage->save();

        $input = $request->all();

        $current_stock = $vars->stock;
        $addstock = $request->stock;

        $newstock = ($current_stock) + ($addstock);

        if ($newstock < 0) {
            notify()->error(__('Stock cannot be less than 0 !'));

            return back();
        }

        if (isset($request->def)) {

            //Removing Other Def If Any
            foreach ($all_def as $value) {
                if ($vars->id != $value->id) {
                    $remove_def = AddSubVariant::where('id', '=', $value->id)
                        ->update(['def' => 0]);
                }
            }

            $input['def'] = 1;
        } else {
            if ($all_def2->count() <= 1) {
                notify()->warning(__('Atleast one value should be set to default !'));

                return back();
            }
        }

        foreach ($array2 as $key => $value) {
            $array1 = $value->main_attr_value;

            $test = $input['main_attr_value'];

            $result = array_diff($array1, $test);

            if (null == $result) {
                if ($id == $value->id) {
                    if ('' == $request->stock) {
                        $input['stock'] = $vars->stock;
                    } else {
                        $input['stock'] = $vars->stock + $request->stock;
                    }

                    $vars->update($input);

                    notify()->success(__('Variant has been Updated !'));

                    return redirect()->route('seller.add.var', $vars->pro_id);
                }

                notify()->success(__('Linked Variant already exist !'));

                return back();
            }
            foreach ($result as $e => $new) {
                if (0 == $new) {
                    if ($id == $value->id) {
                        if ('' == $request->stock) {
                            $input['stock'] = $vars->stock;
                        } else {
                            $existstock = $vars->stock;
                            $input['stock'] = $vars->stock + $request->stock;
                        }

                        $vars->update($input);

                        notify()->success(__('Linked Variant Updated !'));

                        return redirect()->route('seller.add.var', $vars->pro_id);
                    }

                    notify()->warning(__('Linked Variant exist !'));

                    return back();
                }
            }
        }

        if ('' == $request->stock) {
            $input['stock'] = $vars->stock;
        } else {
            $input['stock'] = $vars->stock + $request->stock;
        }

        $vars->update($input);

        notify()->success(__('Variant Updated !'));

        return redirect()->route('seller.add.var', $vars->pro_id);
    }

    public function gettingvar(Request $request)
    {
        $id = $request->id;
        $name = $request->value;
        $attr_name = $request->attr_name;

        $allvalues = AddSubVariant::all();

        $conversion_rate = [];

        foreach ($allvalues as $g) {
            $conversion_rate[] = $g->main_attr_value;
        }

        $testing = [];
        $getvalname2 = [];
        foreach ($conversion_rate as $key => $val) {
            if ($val[$attr_name] === $name) {
                $testing[] = $val;
                if (0 == $id) {
                    $getvalname = ProductValues::where('id', '=', $val[2])->first()->values;
                    $getvalname2[] = $getvalname;
                } else {
                    $getvalname = ProductValues::where('id', '=', $val[1])->first()->values;
                    $getvalname2[] = $getvalname;
                }
            }
        }
        $test2 = '';
        if (0 == $id) {
            $test2 = 1;
        } else {
            $test2 = 0;
        }

        if (0 == $id) {
        }

        return response()->json([$testing, $test2, $getvalname2]);
    }

    public function ajaxGet(Request $request, $id)
    {
        $attr_name = $request->attr_name;
        $value = $request->value;
        $array1 = $request->arr;

        $newarr = [];
        $arr_count = \count($array1);
        if ($arr_count > 1) {
            array_push($newarr, [$array1[0]['key'] => $array1[0]['value'], $array1[1]['key'] => $array1[1]['value']]);
        } else {
            array_push($newarr, [$array1[0]['key'] => $array1[0]['value'],

            ]);
        }

        $t = \count($newarr);

        $p_attr_id = ProductAttributes::where('attr_name', '=', $attr_name)->first()->id;

        $all_var = AddSubVariant::where('pro_id', '=', $id)->with('variantimages')
            ->get();

        foreach ($all_var as $var) {
            if ($newarr[0] == $var['main_attr_value']) {
                return $var;
            }
        }
    }

    // On load data

    public function ajaxGet2(Request $request, $id)
    {
        $array1 = $request->arr;
        $newarr = [];
        $arr_count = \count($array1);

        if ($arr_count > 1) {
            array_push($newarr, [$array1[0]['key'] => $array1[0]['value'], $array1[1]['key'] => $array1[1]['value']]);
        } else {
            array_push($newarr, [$array1[0]['key'] => $array1[0]['value'],

            ]);
        }

        //Get all variant with this id
        $all_sub_var = AddSubVariant::where('pro_id', '=', $id)->with('variantimages')
            ->get();

        foreach ($all_sub_var as $value) {
            if ($value['main_attr_value'] == $newarr[0]) {
                return $value;
            }
        }
    }

    public function quicksetdefault(Request $request, $id)
    {
        $pro_id = $request->pro_id;
        $addsub = AddSubVariant::findorfail($id);

        $all_def = AddSubVariant::where('def', '=', 1)->where('pro_id', $pro_id)->get();
        $all_def2 = AddSubVariant::where('pro_id', $pro_id)->get();

        $c = \count($all_def2);

        if ($all_def2->count() <= 1) {
            return response()
                ->json([
                    'count' => $c,
                    'msg' => __('Atleast one value should set to be default'),
                ]);
        }

        foreach ($all_def as $value) {
            if ($id != $value->id) {
                AddSubVariant::where('id', '=', $value->id)
                    ->update(['def' => 0]);
            }
        }

        AddSubVariant::where('id', '=', $id)->update(['def' => 1]);

        return response()
            ->json([
                'msg' => __('Default Variant is changed !'),
                'count' => $c,
                'id' => $id,
            ]);
    }
}
