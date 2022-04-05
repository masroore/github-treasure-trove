<?php

namespace Modules\AdminProductOption\Http\Controllers;

use App\Models\Option;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Modules\AdminCategory\Imports\CategoryDescriptionImport;
use Modules\AdminCategory\Imports\CategoryImport;
use Modules\AdminProduct\Imports\ProductCategoryImport;
use Modules\AdminProduct\Imports\ProductDescriptionImport;
use Modules\AdminProduct\Imports\ProductImageImport;
use Modules\AdminProduct\Imports\ProductImport;
use Modules\AdminProduct\Imports\ProductOptionImport;
use Modules\AdminProduct\Imports\ProductOptionValueImport;
use Modules\AdminProduct\Imports\ProductRelatedProductImport;
use Modules\AdminProductOption\Http\Requests\CreateAdminProductOptionRequest;
use Modules\AdminProductOption\Http\Requests\UpdateAdminProductOptionRequest;
use Modules\AdminProductOption\Imports\OptionImport;
use Modules\AdminProductOption\Imports\OptionNameImport;
use Modules\AdminProductOption\Imports\OptionValueImageImport;
use Modules\AdminProductOption\Imports\OptionValueImport;
use Modules\AdminProductOption\Services\CreateAdminProductOptionService;
use Modules\AdminProductOption\Services\UpdateAdminProductOptionService;

class AdminProductOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $data = [
            'menu' => 'options',
        ];

        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $options = Option::where('type', 'LIKE', "%$keyword%")
                ->orWhere('name', 'LIKE', "%$keyword%")
                ->orWhere('sort_order', 'LIKE', "%$keyword%")
                ->with('optionValues')
                ->orderByDesc('id')
                ->get();
        } else {
            $options = Option::with('optionValues')->orderByDesc('id')->get();
        }

        return view('adminproductoption::index', compact('options'), $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $data = [
            'menu' => 'options',
        ];

        return view('adminproductoption::create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(CreateAdminProductOptionRequest $request, CreateAdminProductOptionService $service)
    {
        $validatedData = $request->validated();

        if ($service->handle($validatedData)) {
            session()->flash('success_message', 'Product Option information added stored successfully.');
        } else {
            session()->flash('error_message', 'Product Option could not be stored.');

            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.product.options.index');
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
        return view('adminproductoption::show');
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
            'menu' => 'options',
        ];
        $option = Option::where('id', $id)->with('optionValues')->first();

        return view('adminproductoption::edit', compact('option'), $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function update(UpdateAdminProductOptionRequest $request, $id, UpdateAdminProductOptionService $service)
    {
        $validatedData = $request->validated();

        if ($service->handle($validatedData, $id)) {
            session()->flash('success_message', 'Product Option updated successfully.');
        } else {
            session()->flash('error_message', 'Product Option could not be updated.');

            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.product.options.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function delete($id)
    {
        try {
            Option::find($id)->delete();
            session()->flash('success_message', 'Product Option deleted successfully.');
        } catch (Exception $e) {
            session()->flash('error_message', 'Product Option could not be deleted.');
        }

        return redirect()->route('admin.product.options.index');
    }

    // public function uploadProductMedia(Request $request){
    // 	$image = $request->file('file');
    //     $imageName = time().$image->getClientOriginalName();
    //     $upload_success = $image->move(storage_path('images/products'),$imageName);

    //     $productImage = ProductGallery::create([
    //         'image'=>$imageName
    //     ]);

    //     if ($upload_success) {
    //         return response()->json($productImage->id, 200);
    //     }
    //     // Else, return error 400
    //     else {
    //         return response()->json('error', 400);
    //     }
    // }

    public function importFromExcel()
    {
        $response = [];
        // option
        $optionTypeFile = storage_path('files/options/option_type.csv');
        $optionTypeFileExist = file_exists($optionTypeFile);
        if ($optionTypeFileExist) {
            if (Excel::import(new OptionImport(), $optionTypeFile)) {
                $response['option_type'] = 'File Queued for Importing.';
            // session()->flash('success_message', 'File Queued for Importing.');
            } else {
                $response['option_type'] = 'File Could not be Updated.';
                // session()->flash('error_message', 'Option could not be updated.');
            }
        }

        // Option Name

        $optionNameTypeFile = storage_path('files/options/option_name.csv');
        $optionNameTypeFileExist = file_exists($optionNameTypeFile);
        if ($optionNameTypeFileExist) {
            if (Excel::import(new OptionNameImport(), $optionNameTypeFile)) {
                $response['option_name'] = 'File Queued for Importing.';
            // session()->flash('success_message', 'File Queued for Importing.');
            } else {
                $response['option_name'] = 'File could not be Updated.';
                // session()->flash('error_message', 'Option could not be updated.');
            }
        }

        // option value description
        $optionValueDescriptionFile = storage_path('files/options/option_value_description.csv');
        $optionValueDescriptionExist = file_exists($optionValueDescriptionFile);
        if ($optionValueDescriptionExist) {
            if (Excel::import(new OptionValueImport(), $optionValueDescriptionFile)) {
                $response['option_value_description'] = 'File Queued for Importing.';
            // session()->flash('success_message', 'File Queued for Importing.');
            } else {
                $response['option_value_description'] = 'File could not be Updated.';

                // session()->flash('error_message', 'Option could not be updated.');
            }
        }

        // option value image and sortorder
        $optionValueImageFile = storage_path('files/options/option_value_image.csv');
        $optionValueImageExist = file_exists($optionValueImageFile);
        if ($optionValueImageExist) {
            if (Excel::import(new OptionValueImageImport(), $optionValueImageFile)) {
                $response['option_value_image'] = 'File Queued for Importing.';
            // session()->flash('success_message', 'File Queued for Importing.');
            } else {
                $response['option_value_image'] = 'File could not be Updated.';

                // session()->flash('error_message', 'Option could not be updated.');
            }
        }

        // category
        $categoryFile = storage_path('files/category/category.csv');
        $categoryFileExist = file_exists($categoryFile);
        if ($categoryFileExist) {
            if (Excel::import(new CategoryImport(), $categoryFile)) {
                $response['category'] = 'File Queued for Importing.';
            // session()->flash('success_message', 'File Queued for Importing.');
            } else {
                $response['category'] = 'File could not be Updated.';

                // session()->flash('error_message', 'Option could not be updated.');
            }
        }

        // category Description
        $CategoryDescriptionFile = storage_path('files/category/category_description.csv');
        $CategoryDescriptionFileExist = file_exists($CategoryDescriptionFile);
        if ($CategoryDescriptionFileExist) {
            if (Excel::import(new CategoryDescriptionImport(), $CategoryDescriptionFile)) {
                $response['category_description'] = 'File Queued for Importing.';
            // session()->flash('success_message', 'File Queued for Importing.');
            } else {
                $response['category_description'] = 'File could not be Updated.';

                // session()->flash('error_message', 'Option could not be updated.');
            }
        }

        // product
        $productFile = storage_path('files/product/product.csv');
        $productFileExist = file_exists($productFile);
        if ($productFileExist) {
            if (Excel::import(new ProductImport(), $productFile)) {
                $response['product'] = 'File Queued for Importing.';
            // session()->flash('success_message', 'File Queued for Importing.');
            } else {
                $response['product'] = 'File could not be Updated.';

                // session()->flash('error_message', 'Option could not be updated.');
            }
        }

        // product  description
        $productDescriptionFile = storage_path('files/product/product_description.csv');
        $productDescriptionFileExist = file_exists($productDescriptionFile);
        if ($productDescriptionFileExist) {
            if (Excel::import(new ProductDescriptionImport(), $productDescriptionFile)) {
                $response['product_description'] = 'File Queued for Importing.';
            // session()->flash('success_message', 'File Queued for Importing.');
            } else {
                $response['product_description'] = 'File could not be Updated.';

                // session()->flash('error_message', 'Option could not be updated.');
            }
        }

        // product related product
        $productRelatedProductFile = storage_path('files/product/product_related.csv');
        $productRelatedProductFileExist = file_exists($productRelatedProductFile);
        if ($productRelatedProductFileExist) {
            if (Excel::import(new ProductRelatedProductImport(), $productRelatedProductFile)) {
                $response['product_related_product'] = 'File Queued for Importing.';
            // session()->flash('success_message', 'File Queued for Importing.');
            } else {
                $response['product_related_product'] = 'File could not be Updated.';

                // session()->flash('error_message', 'Option could not be updated.');
            }
        }

        //   // product Image
        $productImageFile = storage_path('files/product/product_image.csv');
        $productImageFileExist = file_exists($productImageFile);
        if ($productImageFileExist) {
            if (Excel::import(new ProductImageImport(), $productImageFile)) {
                $response['product_image'] = 'File Queued for Importing.';
            // session()->flash('success_message', 'File Queued for Importing.');
            } else {
                $response['product_image'] = 'File could not be Updated.';

                // session()->flash('error_message', 'Option could not be updated.');
            }
        }

        // product Option
        $productOptionFile = storage_path('files/product/product_option.csv');
        $productOptionFileExist = file_exists($productOptionFile);
        if ($productOptionFileExist) {
            if (Excel::import(new ProductOptionImport(), $productOptionFile)) {
                $response['product_option'] = 'File Queued for Importing.';
            // session()->flash('success_message', 'File Queued for Importing.');
            } else {
                $response['product_option'] = 'File could not be Updated.';

                // session()->flash('error_message', 'Option could not be updated.');
            }
        }

        // product Option Value
        $productOptionValueFile = storage_path('files/product/product_option_value.csv');
        $productOptionValueFileExist = file_exists($productOptionValueFile);
        if ($productOptionValueFileExist) {
            if (Excel::import(new ProductOptionValueImport(), $productOptionValueFile)) {
                $response['product_option_value'] = 'File Queued for Importing.';
            // session()->flash('success_message', 'File Queued for Importing.');
            } else {
                $response['product_option_value'] = 'File could not be Updated.';

                // session()->flash('error_message', 'Option could not be updated.');
            }
        }

        // product category
        $productCategoryFile = storage_path('files/product/product_to_category.csv');
        $productCategoryFileExist = file_exists($productCategoryFile);
        if ($productCategoryFileExist) {
            if (Excel::import(new ProductCategoryImport(), $productCategoryFile)) {
                $response['product_to_category'] = 'File Queued for Importing.';
            // session()->flash('success_message', 'File Queued for Importing.');
            } else {
                $response['product_to_category'] = 'File could not be Updated.';

                // session()->flash('error_message', 'Option could not be updated.');
            }
        }

        return $response;
    }
}
