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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Image;

class AddSubVariantController extends Controller
{
    public function getIndex($id)
    {
        $findpro = Product::findorfail($id);

        return view('admin.productvariant.subvar', compact('findpro'));
    }

    public function post(Request $request, $id)
    {
        $request->validate(
            [
                'main_attr_id' => 'required',
                'main_attr_value' => 'required', 'image1' => 'required|mimes:png,jpg,jpeg,gif|max:1024', ],
            ['main_attr_id.required' => 'Please select an option', 'main_attr_value.required' => 'Please select a value', 'image1.required' => 'Atleast one image is required']
        );

        $input = $request->all();

        $array2 = AddSubVariant::where('pro_id', $id)->get();

        foreach ($array2 as $key => $value) {
            $array1 = $value->main_attr_value;

            $test = $input['main_attr_value'];

            $conversion_rate = array_diff($array1, $test);

            if (null == $conversion_rate) {
                return back()->with('warning', __('Variant already exist ! Kindly Update that'));
            }
            foreach ($conversion_rate as $e => $new) {
                if (0 == $new) {
                    return back()->with('warning', __('Variant exist Kindly Update it !'));
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
                return back()
                    ->with('warning', __('Atleast one variant should be set to default !'));
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

        return redirect()
            ->route('add.var', $id)->with('added', __('Variant Linked Successfully !'));
    }

    public function edit($id)
    {
        $vars = AddSubVariant::findorfail($id);

        return view('admin.productvariant.edit', compact('vars'));
    }

    public function delete($id)
    {
        $vars = AddSubVariant::findorfail($id);

        if (1 != $vars->def) {

            // Delete Variant Images first

            if ($vars->variantimages) {
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
            return back()
                ->with('warning', __('Default variant cannot be deleted !'));
        }

        return back()
            ->with('deleted', __('Variant has been deleted !'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(['min_order_qty' => 'numeric|min:1'], ['min_order_qty.min' => __('Minimum order quantity must be atleast 1')]);

        if (!$request->main_attr_value) {
            return back()->withErrors([__('You did not selected product attribute')])->withInput();
        }

        $vars = AddSubVariant::find($id);

        if (!$vars) {
            notify()->error(__('Product variant not found !'));

            return back();
        }

        $array2 = AddSubVariant::where('pro_id', $vars->pro_id)->get();
        $all_def = AddSubVariant::where('def', '=', 1)->where('pro_id', $vars->pro_id)->get();
        $all_def2 = AddSubVariant::where('pro_id', $vars->pro_id)->get();

        if ($all_def2->count() < 1) {
            return back()->with('warning', __('Atleast one value should be set to default !'));
        }

        $varimage = VariantImages::where('var_id', $id)->first();

        if (!$varimage) {
            $varimage = new VariantImages();
            $varimage->var_id = $vars->id;
        }

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

        $path = public_path() . '/variantimages';

        $thumbpath = public_path() . '/variantimages/thumbnails';

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

            if (file_exists(public_path() . '/variantimages/hoverthumbnail/' . $varimage->image2)) {
                unlink(public_path() . '/variantimages/hoverthumbnail/' . $varimage->image2);
            }

            $hoverthumb = $name;

            $img->resize(300, 300, function ($constraint): void {
                $constraint->aspectRatio();
            });

            $img->save(public_path() . '/variantimages/hoverthumbnail/' . $hoverthumb, 95);
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
                if (file_exists($thumbpath . '/' . $varimage->main_image)) {
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
            return back()->with('deleted', __('Stock cannot be less than 0 !'));
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
            if ($all_def2->count() < 1) {
                return back()
                    ->with('warning', __('Atleast one value should be set to default !'));
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
                        $existstock = $vars->stock;
                        $input['stock'] = $vars->stock + $request->stock;
                    }

                    $vars->update($input);

                    return redirect()->route('add.var', $vars->pro_id)
                        ->with('updated', __('Variant has been Updated !'));
                }

                return back()
                    ->with('warning', __('Linked Variant already exist !'));
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

                        return redirect()->route('add.var', $vars->pro_id)
                            ->with('updated', __('Linked Variant Updated !'));
                    }

                    return back()
                        ->with('warning', __('Linked Variant exist !'));
                }
            }
        }

        if ('' == $request->stock) {
            $input['stock'] = $vars->stock;
        } else {
            $existstock = $vars->stock;
            $input['stock'] = $vars->stock + $request->stock;
        }

        $vars->update($input);

        return redirect()->route('add.var', $vars->pro_id)
            ->with('updated', __('Variant Updated !'));
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
        $array1 = $request->arr;

        $newarr = [];
        $arr_count = \count($array1);
        if ($arr_count > 1) {
            array_push($newarr, [$array1[0]['key'] => $array1[0]['value'], $array1[1]['key'] => $array1[1]['value']]);
        } else {
            $newarr[] = [$array1[0]['key'] => $array1[0]['value']];
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
            if ($newarr[0] == $value['main_attr_value']) {
                return response()->json($value);
            }
        }
    }

    public function getDefaultforFailed(Request $request, $id)
    {

        // Get default variant if varaint combination is not found

        if ($request->ajax()) {
            if (\count($request->arr) > 1) {
                $value1 = $request->arr[0]['value'];
                $value2 = $request->arr[1]['value'];
                $findvalues1 = ProductValues::find($value1);
                $findvalues2 = ProductValues::find($value2);

                //return $findvalues2->proattr;

                $name1 = '';
                $name2 = '';

                if (isset($findvalues1)) {
                    if ('color' == $findvalues1->proattr->attr_name || 'Color' == $findvalues1->proattr->attr_name || 'colour' == $findvalues1->proattr->attr_name || 'Colour' == $findvalues1->proattr->attr_name) {
                        $name1 = $findvalues1->values;
                    } else {
                        $name1 = $findvalues1->values . $findvalues1->unit_value;
                    }
                }

                if (isset($findvalues2)) {
                    if ('color' == $findvalues2->proattr->attr_name || 'Color' == $findvalues2->proattr->attr_name || 'colour' == $findvalues2->proattr->attr_name || 'Colour' == $findvalues2->proattr->attr_name) {
                        $name2 = $findvalues2->values;
                    } else {
                        $name2 = $findvalues2->values . $findvalues2->unit_value;
                    }
                }

                $msg = "$name1 is not available in $name2";

                $defvariant = AddSubVariant::where('def', '=', 1)->where('pro_id', $id)->with('variantimages')->first();

                foreach ($defvariant->main_attr_value as $attr => $var) {
                    $attrname = ProductAttributes::find($attr);

                    $setdefvariant[$attrname->attr_name] = $var;
                }

                return response()->json(['msg' => $msg, 'data' => $defvariant, 'setdefvariant' => $setdefvariant]);
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
