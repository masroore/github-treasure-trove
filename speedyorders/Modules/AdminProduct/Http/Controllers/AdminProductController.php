<?php

namespace Modules\AdminProduct\Http\Controllers;

use App\Models\Category;
use App\Models\Option;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductGallery;
use App\Models\ProductOption;
use App\Models\ProductOptionValue;
use App\Models\ShippingPackage;
use App\Models\ShippingZoneGroup;
use App\Models\ShippingZonePrice;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\AdminProduct\Http\Requests\CreateProductRequest;
use Modules\AdminProduct\Http\Requests\ImportProductRequest;
use Modules\AdminProduct\Http\Requests\UpdateProductRequest;
use Modules\AdminProduct\Services\CreateProductService;
use Modules\AdminProduct\Services\ImportProductService;
use Modules\AdminProduct\Services\UpdateProductService;

class AdminProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = [
            'menu' => 'products',
        ];
        $products = Product::select('id', 'name', 'sku', 'base_price', 'quantity', 'status', 'return_policy_days')->orderByDesc('id')->get();

        return view('adminproduct::index', compact('products'), $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $data = [
            'menu' => 'products',
        ];

        //$categories = Category::where(['category_id'=>null])->select('id','name')->get();
        $categories = Category::where(['category_id'=>0])->orWhere(['category_id'=>null])->select('id', 'name')->get();
        $products = Product::where('status', 1)->select('id', 'name')->get();
        $options = Option::orderBy('sort_order')->get();

        $groups = ShippingZoneGroup::select('id', 'group_name')->get();
        $packages = ShippingPackage::select('id', 'package_name')->get();
        $relatedProductIds = [];

        $productCategories = [];

        return view('adminproduct::create', compact('categories', 'relatedProductIds', 'productCategories', 'options', 'products', 'groups', 'packages'), $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(CreateProductRequest $request, CreateProductService $service)
    {
        $validatedData = $request->validated();

        if ($service->handleGeneralInformation($validatedData)) {
            session()->flash('success_message', 'Product General information added stored successfully.');
        } else {
            session()->flash('error_message', 'Product could not be stored.');

            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.products.index');
    }

    /**
     * Show the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        return view('adminproduct::show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $data = [
            'menu' => 'products',
        ];
        $options = Option::orderBy('sort_order')->get();
        $product = Product::where('id', $id)->with('options', 'options.optionValues', 'groups', 'relatedProducts', 'delivery_time')->first();
        $products = Product::where('status', 1)->select('id', 'name')->get();
        $categories = Category::where(['category_id'=>0])->orWhere(['category_id'=>null])->select('id', 'name')->get();
        $productCategories = ProductCategory::where('product_id', $id)->pluck('category_id')->toArray();
        $productGalleries = ProductGallery::where('product_id', $id)->select(['id', 'image', 'order'])->get();
        $optionsId = ProductOption::where('product_id', $id)->pluck('option_id');
        $productOptionValues = ProductOptionValue::whereIn('option_id', $optionsId)->get();
        $groups = ShippingZoneGroup::select('id', 'group_name')->get();

        $packages = ShippingPackage::select('id', 'package_name')->get();

        $relatedProductIds = [];
        if (isset($product->relatedProducts) && !empty($product->relatedProducts)) {
            $relatedProductIds = array_column($product->relatedProducts->toArray(), 'related_product_id');
        }

        $productDeliveryTimeGroup = $productDeliveryTimePackage = '';
        $deliveryTimes = [];
        if (isset($product->delivery_time) && !empty($product->delivery_time)) {
            foreach ($product->delivery_time as $timeData) {
                $productDeliveryTimePackage = $timeData->shipping_packages_id;
                $productDeliveryTimeGroup = $timeData->shipping_zone_groups_id;

                $deliveryTimes[] = $timeData->shipping_delivery_times_id;
            }
        }

        return view('adminproduct::edit', compact('product', 'categories', 'productCategories', 'options', 'products', 'productGalleries', 'productOptionValues', 'groups', 'relatedProductIds', 'packages', 'deliveryTimes', 'productDeliveryTimeGroup', 'productDeliveryTimePackage'), $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function update(UpdateProductRequest $request, $id, UpdateProductService $service)
    {
        $validatedData = $request->validated();

        if ($service->handle($validatedData, $id)) {
            session()->flash('success_message', 'Product updated successfully.');
        } else {
            session()->flash('error_message', 'Product could not be updated.');

            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        try {
            Product::find($id)->delete();
            session()->flash('success_message', 'Product deleted successfully.');
        } catch (\Exception $e) {
            session()->flash('error_message', 'Product could not be deleted.');
        }

        return redirect()->route('admin.products.index');
    }

    public function updateProductStatus($id)
    {
        try {
            $product = Product::find($id);
            if ('1' == $product->status) {
                $status = '0';
            } else {
                $status = '1';
            }
            Product::where('id', $id)->first()->update(['status' => $status]);
            session()->flash('success_message', 'Product updated successfully.');
        } catch (\Exception $e) {
            session()->flash('error_message', 'Product could not be updated.');
        }

        return redirect()->route('admin.products.index');
    }

    public function uploadProductMedia(Request $request)
    {
        $gallery_images = $request->file('gallery_images');

        $galleries = [];
        $galleryId = [];

        for ($i = 0; $i < \count($gallery_images); $i++) {
            $image = $gallery_images[$i];
            $imageName = uniqid() . time() . $image->getClientOriginalName();
            $upload_success = $image->move(public_path('images/products'), $imageName);
            $gallery = ProductGallery::create([
                'image'=> $imageName,
                'order'=> $i,
            ]);
            $galleryId[] = $gallery->id;
            $galleries[] = $gallery;
        }

        return response()->json(['data'=>array_reverse($galleries), 'id'=>array_reverse($galleryId)], 200);
    }

    public function getProductMedia($ids)
    {
        $galleryIdsArray = explode(',', $ids);
        $galleryData = ProductGallery::whereIn('id', $galleryIdsArray)->get();

        return response()->json(['data'=>$galleryData], 200);
    }

    public function getSingleProductMedia($id)
    {
        $galleryData = ProductGallery::where('id', $id)->first();

        return response()->json(['data'=>$galleryData], 200);
    }

    public function updateSingleProductMedia(Request $request)
    {
        $arrayData = [];
        if ($request->has('galleryImage')) {
            $image = $request->galleryImage;
            $imageName = uniqid() . time() . $image->getClientOriginalName();
            $upload_success = $image->move(public_path('images/products'), $imageName);
            $arrayData['image'] = $imageName;
        }

        $arrayData['product_option_value_id'] = $request->optionValueId;
        $arrayData['order'] = $request->order;

        ProductGallery::where('id', $request->singleGalleryId)->first()->update($arrayData);

        $data = ProductGallery::find($request->singleGalleryId);

        return response()->json(['data'=>$data], 200);
    }

    public function deleteProductMedia($id)
    {
        $deletedMedia = ProductGallery::where('id', $id)->delete();

        return response()->json(['data'=>$id], 200);
    }

    public function getProductGroupData($id)
    {
        $groupData = ShippingZonePrice::with(['deliverytime', 'group', 'package'])->where('shipping_zone_groups_id', $id)->get();

        return response()->json(['data'=>$groupData], 200);
    }

    /**
     * Import the products from csv file.
     *
     * @return Response
     */
    public function import()
    {
        $data = [
            'menu' => 'products',
        ];

        return view('adminproduct::import');
    }

    /**
     * import all the csv products in to the DB table products and related tables.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function importData(ImportProductRequest $request, ImportProductService $service)
    {
        $validatedData = $request->validated();

        if ($service->handle($validatedData)) {
            session()->flash('success_message', 'Products imported successfully.');
        } else {
            session()->flash('error_message', 'Products imported could not be stored.');

            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.products.index');
    }
}
