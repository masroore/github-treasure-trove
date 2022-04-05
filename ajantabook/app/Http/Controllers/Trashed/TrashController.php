<?php

namespace App\Http\Controllers\Trashed;

use App\Http\Controllers\Controller;
use App\Product;
use App\SimpleProduct;
use Exception;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TrashController extends Controller
{
    // Function to get soft deleted variant products

    public function getTrashedVariantProduct()
    {
        abort_if(!auth()->user()->can('products.delete'), 403, __('User does not have the right permissions.'));

        if (!\in_array('Seller', auth()->user()->getRoleNames()->toArray())) {
            $products = Product::onlyTrashed()
                ->select(['id', 'name', 'status']);
        } else {
            $products = Product::where('vender_id', auth()->id())
                ->onlyTrashed()
                ->select(['id', 'name', 'status']);
        }

        if (request()->ajax()) {
            return DataTables::of($products)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return $row->name;
                })
                ->addColumn('status', function ($row) {
                    return 1 == $row->status ? '<span class="badge badge-success btn-rounded">' . __('Active') . '</span>
                            ' : '<span class="label label-danger">' . __('Deactive') . '</span>';
                })
                ->editColumn('action', 'admin.product.bin.action')
                ->rawColumns(['name', 'status', 'action'])
                ->make(true);
        }

        return view('admin.product.bin.trash');
    }

    public function forceDeleteVariantProduct($id)
    {
        abort_if(!auth()->user()->can('products.delete'), 403, __('User does not have the right permissions.'));

        $products = Product::onlyTrashed()->findorfail($id);

        $products->comments()->delete();

        $products->hotdeal()->delete();

        $products->specialoffer()->delete();

        $products->variants()->delete();

        if (isset($products->subvariants)) {
            foreach ($products->subvariants as $s) {
                $s->flashdeal()->delete();

                if (null != $s->variantimages['image1'] && file_exists(public_path() . '/variantimages/' . $s->variantimages['image1'])) {
                    unlink(public_path() . '/variantimages/' . $s->variantimages['image1']);
                }

                if (null != $s->variantimages['image2'] && file_exists(public_path() . '/variantimages/' . $s->variantimages['image2'])) {
                    unlink(public_path() . '/variantimages/' . $s->variantimages['image2']);
                }

                if (null != $s->variantimages['image3'] && file_exists(public_path() . '/variantimages/' . $s->variantimages['image3'])) {
                    unlink(public_path() . '/variantimages/' . $s->variantimages['image3']);
                }

                if (null != $s->variantimages['image4'] && file_exists(public_path() . '/variantimages/' . $s->variantimages['image4'])) {
                    unlink(public_path() . '/variantimages/' . $s->variantimages['image4']);
                }

                if (null != $s->variantimages['image5'] && file_exists(public_path() . '/variantimages/' . $s->variantimages['image5'])) {
                    unlink(public_path() . '/variantimages/' . $s->variantimages['image5']);
                }

                if (null != $s->variantimages['image6'] && file_exists(public_path() . '/variantimages/' . $s->variantimages['image6'])) {
                    unlink(public_path() . '/variantimages/' . $s->variantimages['image6']);
                }

                DB::table('variant_images')
                    ->where('var_id', $s->id)
                    ->delete();
            }
        }

        $products->subvariants()->forcedelete();

        $products->commonvars()->delete();

        $products->reviews()->delete();

        $products->relproduct()->delete();

        $products->relsetting()->delete();

        $products->specs()->delete();

        $products->faq()->delete();

        $products->forceDelete();

        notify()->success(__('Product has been permanently deleted !'), __('Success'));

        return back();
    }

    public function restorevariantProducts($id)
    {
        abort_if(!auth()->user()->can('products.delete'), 403, __('User does not have the right permissions.'));

        $products = Product::onlyTrashed()->findorfail($id);

        $products->subvariants()->restore();

        $products->restore();

        notify()->success(__('Product has been restored successfully !'), __('Success'));

        return back();
    }

    // Function to get soft deleted simp,e products

    public function getTrashedSimpleProduct()
    {
        abort_if(!auth()->user()->can('products.delete'), 403, __('User does not have the right permissions.'));

        if (\in_array('Seller', auth()->user()->getRoleNames()->toArray())) {
            $products = SimpleProduct::onlyTrashed()->where('store_id', '=', auth()->user()->store->id)->select(['id', 'product_name', 'status']);
        } else {
            $products = SimpleProduct::onlyTrashed()->select(['id', 'product_name', 'status']);
        }

        if (request()->ajax()) {
            return DataTables::of($products)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return $row->product_name;
                })
                ->addColumn('status', function ($row) {
                    return 1 == $row->status ? '<span class="label label-success">' . __('Active') . '</span>
                            ' : '<span class="label label-danger">' . __('Deactive') . '</span>';
                })
                ->editColumn('action', 'admin.simpleproducts.bin.action')
                ->rawColumns(['name', 'status', 'action'])
                ->make(true);
        }

        return view('admin.simpleproducts.bin.trash');
    }

    public function restoresimpleProducts($id)
    {
        abort_if(!auth()->user()->can('products.delete'), 403, __('User does not have the right permissions.'));

        $product = SimpleProduct::onlyTrashed()->findOrFail($id);

        $product->productGallery()->restore();

        $product->restore();

        notify()->success(__('Product has been restored'), __('Success'));

        return back();
    }

    public function forceDeleteSimpleProduct($id)
    {
        abort_if(!auth()->user()->can('products.delete'), 403, __('User does not have the right permissions.'));

        $product = SimpleProduct::onlyTrashed()->findOrFail($id);

        if ('' != $product->thumbnail && file_exists(public_path() . '/images/simple_products/' . $product->thumbnail)) {
            unlink(public_path() . '/images/simple_products/' . $product->thumbnail);
        }

        if ('' != $product->hover_thumbnail && file_exists(public_path() . '/images/simple_products/' . $product->hover_thumbnail)) {
            unlink(public_path() . '/images/simple_products/' . $product->hover_thumbnail);
        }

        if (isset($product->productGallery)) {
            $product->productGallery->each(function ($pro): void {
                try {
                    unlink(public_path() . '/images/simple_products/gallery/' . $pro->image);
                } catch (Exception $e) {
                }
            });
        }

        $product->flashdeal()->delete();

        $product->productGallery()->forceDelete();

        $product->forceDelete();

        notify()->success(__('Product has been permanently deleted !'), 'Success');

        return back();
    }
}
