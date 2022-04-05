<?php

namespace Modules\Product\Http\Controllers;

use App\Traits\Notification;
use App\Traits\PdfGenerate;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use LogActivity;
use Modules\Inventory\Repositories\ShowRoomRepositoryInterface;
use Modules\Inventory\Repositories\StockTransferRepositoryInterface;
use Modules\Inventory\Repositories\WareHouseRepositoryInterface;
use Modules\Product\Entities\PartNumber;
use Modules\Product\Entities\ProductSellingPriceHistory;
use Modules\Product\Http\Requests\ProductFormRequest;
use Modules\Product\Http\Requests\ProductUpdateFormRequest;
use Modules\Product\Repositories\BrandRepositoryInterface;
use Modules\Product\Repositories\CategoryRepositoryInterface;
use Modules\Product\Repositories\ModelTypeRepositoryInterface;
use Modules\Product\Repositories\ProductRepositoryInterface;
use Modules\Product\Repositories\UnitTypeRepositoryInterface;
use Modules\Product\Repositories\VariantRepositoryInterface;
use PDF;

class ProductController extends Controller
{
    use Notification;
    use PdfGenerate;

    protected $modelRepository;

    protected $unitTypeRepository;

    protected $brandRepository;

    protected $categoryRepository;

    protected $variationRepository;

    protected $productRepository;

    protected $wareHouseRepository;

    protected $showRoomRepository;

    protected $stockTransferRepository;

    public function __construct(
        ModelTypeRepositoryInterface $modelRepository,
        UnitTypeRepositoryInterface $unitTypeRepository,
        BrandRepositoryInterface $brandRepository,
        CategoryRepositoryInterface $categoryRepository,
        VariantRepositoryInterface $variationRepository,
        ProductRepositoryInterface $productRepository,
        WareHouseRepositoryInterface $wareHouseRepository,
        ShowRoomRepositoryInterface $showRoomRepository,
        StockTransferRepositoryInterface $stockTransferRepository
    )
    {
        $this->middleware(['auth', 'verified']);
        $this->modelRepository = $modelRepository;
        $this->unitTypeRepository = $unitTypeRepository;
        $this->brandRepository = $brandRepository;
        $this->categoryRepository = $categoryRepository;
        $this->variationRepository = $variationRepository;
        $this->productRepository = $productRepository;
        $this->wareHouseRepository = $wareHouseRepository;
        $this->showRoomRepository = $showRoomRepository;
        $this->stockTransferRepository = $stockTransferRepository;
    }

    public function index()
    {
        try {
            $models = $this->modelRepository->all();
            $units = $this->unitTypeRepository->all();
            $brands = $this->brandRepository->all();
            $categories = $this->categoryRepository->category();
            $sub_categories = $this->categoryRepository->allSubCategory();
            $variants = $this->variationRepository->all();
            $productSkus = $this->productRepository->allProduct();
            $services = $this->productRepository->service();
            $showrooms = $this->showRoomRepository->all();
            $wareHouses = $this->wareHouseRepository->all();

            return view('product::product.add_product', [
                'models' => $models,
                'units' => $units,
                'brands' => $brands,
                'categories' => $categories,
                'sub_categories' => $sub_categories,
                'productSkus' => $productSkus,
                'variants' => $variants,
                'wareHouses' => $wareHouses,
                'showrooms' => $showrooms,
                'services' => $services,
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Something happend Wrong!', 'Error!!');

            return redirect()->back();
        }
    }

    public function category_wise_subcategory($category)
    {
        return $this->categoryRepository->subcategory($category);
    }

    public function variation_list($variant)
    {
        return $this->variationRepository->variantValues($variant);
    }

    public function variant_with_values($variant)
    {
        return $this->variationRepository->variantWithValues($variant);
    }

    public function create(Request $request)
    {
        try {
            $products = $this->productRepository->all();
            $comboProducts = $this->productRepository->allComboProduct();

            return view('product::product.list_products', [
                'products' => $products,
                'comboProducts' => $comboProducts,
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Something happend Wrong!', 'Error!!');

            return redirect()->back();
        }
    }

    public function service(Request $request)
    {
        try {
            $products = $this->productRepository->service();

            return view('product::product.list_service', [
                'products' => $products,
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Something happend Wrong!', 'Error!!');

            return redirect()->back();
        }
    }

    public function serial_key_index($id)
    {
        try {
            $items = PartNumber::where('product_sku_id', $id)->get();
            $product = $this->productRepository->findSku($id);

            return view('product::product.serial_key', [
                'items' => $items,
                'product' => $product,
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Something happend Wrong!', 'Error!!');

            return redirect()->back();
        }
    }

    public function store(ProductFormRequest $request)
    {
        DB::beginTransaction();

        try {
            $product = $this->productRepository->create($request->except('_token'));
            $user_id = null;
            $role_id = null;
            $subject = $request->product_name;
            $class = $product;
            $data = 'A Product Has been Created';
            $url = route('add_product.create');
            $this->sendNotification($class, null, $subject, null, null, $data, $user_id, $role_id, $url);
            DB::commit();
            LogActivity::successLog('New Product - (' . $request->product_name . ') has been created.');
            if ($request->ajax()) {
                return response()->json(['message' => __('product.Product has been added Successfully'), 'goto' => route('add_product.index')]);
            }

            Toastr::success(__('product.Product has been added Successfully'));

            return back();
        } catch (Exception $e) {
            DB::rollBack();
            LogActivity::errorLog($e->getMessage() . ' - Error has been detected for Product creation');
            if ($request->ajax()) {
                return $e;
            }

            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function show($id)
    {
        try {
            $productCombo = $this->productRepository->findCombo($id);
            $productSkus = $this->productRepository->allProduct();

            return view('product::product.edit_combo_product', [
                'productCombo' => $productCombo,
                'productSkus' => $productSkus,
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());

            return response()->json(['error' => $e->getMessage()], 503);
        }
    }

    public function edit($id)
    {
        try {
            $product = $this->productRepository->find($id);
            $product_variant_type = json_decode(collect($product->variations)->pluck('variant_id')->first());
            $units = $this->unitTypeRepository->all();
            $brands = $this->brandRepository->all();
            $categories = $this->categoryRepository->category();
            $variants = $this->variationRepository->all();
            $variant_values = $variants->pluck('values')->flatten()->toArray();
            $models = $this->modelRepository->all();
            $showrooms = $this->showRoomRepository->all();
            $wareHouses = $this->wareHouseRepository->all();

            return view('product::product.edit_product', [
                'models' => $models,
                'product' => $product,
                'units' => $units,
                'brands' => $brands,
                'categories' => $categories,
                'variants' => $variants,
                'variant_values' => $variant_values,
                'product_variant_type' => $product_variant_type,
                'wareHouses' => $wareHouses,
                'showrooms' => $showrooms,
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Something happend Wrong!', 'Error!!');

            return redirect()->back();
        }
    }

    public function update(ProductUpdateFormRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $this->productRepository->update($request->except('_token'), $id);
            DB::commit();

            Toastr::success(__('product.Product has been updated Successfully'));
            if ($request->product_type == 'Service') {
                return redirect()->route('add_product.service');
            }

            return redirect()->route('add_product.create');
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage() . ' - Error has been detected for Product creation');
            DB::rollBack();
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function destroy($id)
    {
        try {
            $this->productRepository->delete($id);
            Toastr::success(__('product.Product has been deleted Successfully'));

            return back();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage() . ' - Error has been detected for Product creation');
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function destroyCombo($id)
    {
        try {
            $this->productRepository->deleteCombo($id);
            Toastr::success(__('product.Product has been deleted Successfully'));

            return back();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage() . ' - Error has been detected for Product creation');
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function product_Detail(Request $request)
    {
        try {
            if ($request->type != 'combo') {
                $product = $this->productRepository->find($request->id);
                $product_variant_type = json_decode(collect($product->variations)->pluck('variant_id')->first());
                $variants = $this->variationRepository->all();
                $variant_values = $variants->pluck('values')->flatten()->toArray();

                return view('product::product.product_details', [
                    'product' => $product,
                    'variants' => $variants,
                    'variant_values' => $variant_values,
                    'product_variant_type' => $product_variant_type,
                    'range' => $request->range,
                ]);
            }
            $product = $this->productRepository->findCombo($request->id);

            return view('product::product.combo_product_details', [
                'product' => $product,
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());

            return response()->json(['error' => $e->getMessage()], 503);
        }
    }

    public function product_sku_get_price(Request $request)
    {
        try {
            return $this->productRepository->getPrice($request->sku_id, $request->purchase_price, $request->selling_price);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());

            return response()->json(['error' => $e->getMessage()], 503);
        }
    }

    public function comboStatus(Request $request)
    {
        try {
            $language = $this->productRepository->findCombo($request->id);
            $language->status = $request->status;
            if ($language->save()) {
                return 1;
            }

            return 0;
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());

            return 'Operation failed';
        }
    }

    public function printLabels(Request $request)
    {
        $price = 0;
        $sku = $this->productRepository->findSku($request->id);
        if ($request->product_price) {
            if ($request->tax == 1) {
                $price = $sku->selling_price + (($sku->price * 20) / 100);
            } else {
                $price = $sku->selling_price;
            }
        }
        $data = [
            'sku' => $sku,
            'name' => $request->name,
            'variation' => $request->variation,
            'business' => $request->business_name,
            'price' => $price,
            'label' => $request->label,
            'page' => $request->page,
        ];

        return view('product::product.labels')->with($data);
    }

    public function pdfLabels()
    {
        $price = 0;
        $sku = $this->productRepository->findSku($request->id);
        if ($request->product_price) {
            if ($request->tax == 1) {
                $price = $sku->selling_price + (($sku->price * 20) / 100);
            } else {
                $price = $sku->selling_price;
            }
        }
        $data = [
            'sku' => $sku,
            'name' => $request->name,
            'variation' => $request->variation,
            'business' => $request->business_name,
            'price' => $price,
            'label' => $request->label,
            'page' => $request->page,
        ];
        $pdf = PDF::loadView('product::product.labels', compact('data'));
        $pdf->setPaper('a4')->setOrientation('landscape')->setOption('margin-bottom', 0);

        return $pdf->download('invoice.pdf');
    }

    public function add_opening_stock_create()
    {
        try {
            $products = $this->productRepository->all();
            $showrooms = $this->showRoomRepository->all();
            $wareHouses = $this->wareHouseRepository->all();
            $stockProducts = $this->stockTransferRepository->allStockProductShowroom();

            return view('product::product.add_opening_stock_create', [
                'products' => $products,
                'wareHouses' => $wareHouses,
                'showrooms' => $showrooms,
                'stockProducts' => $stockProducts,
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Something happend Wrong!', 'Error!!');

            return redirect()->back();
        }
    }

    public function productDetailForStock(Request $request)
    {
        try {
            $product = $this->productRepository->findSku($request->id);

            return view('product::product.stock_add_product_details', [
                'product' => $product,
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Something happend Wrong!', 'Error!!');

            return redirect()->back();
        }
    }

    public function productDetailForPacking(Request $request)
    {
        try {
            $product = $this->productRepository->findSku($request->id);

            return $product;
        } catch (Exception $e) {
            return 0;
        }
    }

    public function selling_price_history($id)
    {
        $data['sell_histories'] = ProductSellingPriceHistory::with('purchase_order', 'productSku', 'user')->where('product_sku_id', $id)->latest()->get();

        return view('product::product.selling_price_history', $data);
    }

    public function csv_upload()
    {
        return view('product::product.upload_via_csv.create');
    }

    public function csv_upload_store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx|max:2048',
        ]);
        ini_set('max_execution_time', 0);
        DB::beginTransaction();

        try {
            $this->productRepository->csv_upload_single_product($request->except('_token'));
            DB::commit();
            Toastr::success('Successfully Uploaded !!!');

            return back();
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
            if ($e->getCode() == 23000) {
                Toastr::error('Duplicate entry is exist in your file !!!');
            } else {
                Toastr::error('Something went wrong. Upload again !!!');
            }

            return back();
        }
    }
}
