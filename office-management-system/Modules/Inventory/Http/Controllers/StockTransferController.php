<?php

namespace Modules\Inventory\Http\Controllers;

use App\Traits\Notification;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use LogActivity;
use Modules\Contact\Repositories\ContactRepositoriesInterface;
use Modules\Inventory\Entities\ShowRoom;
use Modules\Inventory\Entities\WareHouse;
use Modules\Inventory\Http\Requests\StockTransferRequest;
use Modules\Inventory\Repositories\ShowRoomRepositoryInterface;
use Modules\Inventory\Repositories\StockTransferRepositoryInterface;
use Modules\Inventory\Repositories\WareHouseRepositoryInterface;
use Modules\Product\Repositories\BrandRepository;
use Modules\Product\Repositories\ProductRepository;
use Modules\Product\Repositories\ProductRepositoryInterface;
use Modules\Product\Repositories\VariantRepositoryInterface;

class StockTransferController extends Controller
{
    use Notification;

    protected $productRepository;

    protected $wareHouseRepository;

    protected $stockTransferRepository;

    protected $showRoomRepository;

    protected $contactRepositories;

    public function __construct(
        WareHouseRepositoryInterface $wareHouseRepository,
        ProductRepositoryInterface $productRepository,
        StockTransferRepositoryInterface $stockTransferRepository,
        ShowRoomRepositoryInterface $showRoomRepository,
        VariantRepositoryInterface $variationRepository,
        ContactRepositoriesInterface $contactRepositories
    )
    {
        $this->middleware(['auth', 'verified']);
        $this->productRepository = $productRepository;
        $this->wareHouseRepository = $wareHouseRepository;
        $this->stockTransferRepository = $stockTransferRepository;
        $this->showRoomRepository = $showRoomRepository;
        $this->variationRepository = $variationRepository;
        $this->contactRepositories = $contactRepositories;
    }

    public function index()
    {
        try {
            $transfers = $this->stockTransferRepository->all();

            return view('inventory::stock_transfer.index', compact('transfers'));
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Something Went Wrong', 'Error!');

            return back();
        }
    }

    public function stockList(Request $request)
    {
        try {
            $suppliers = $this->contactRepositories->supplier();
            $productRepo = new ProductRepository();
            $brandRepo = new BrandRepository();
            if ($request->showroom || $request->supplier || $request->product_sku_id || $request->brand_id) {
                $house = explode('-', $request->showroom);

                $data = [
                    'stocks' => $this->stockTransferRepository->stockList(),
                    'product_stocks' => stockList($house[0], $house[1], $request->supplier, $request->product_sku_id, $request->brand_id),
                    'showroom' => $request->showroom,
                    'supplier_id' => $request->supplier,
                    'product_sku_id' => $request->product_sku_id,
                    'brand_id' => $request->brand_id,
                    'req_supplier' => $this->contactRepositories->find($request->supplier),
                    'suppliers' => $suppliers,
                    'products' => $productRepo->all(),
                    'brands' => $brandRepo->all(),
                ];
            } else {
                $house[0] = session()->get('showroom_id');
                $house[1] = 'Modules\\Inventory\\Entities\\ShowRoom';
                $data = [
                    'stocks' => $this->stockTransferRepository->stockList(),
                    'product_stocks' => stockList($house[0], $house[1], null, null, null),
                    'products' => $productRepo->all(),
                    'brands' => $brandRepo->all(),
                    'suppliers' => $suppliers,
                ];
            }

            return view('inventory::stock_transfer.stock_list')->with($data);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Operation failed');

            return back();
        }
    }

    public function create()
    {
        try {
            $ProductList = $this->productRepository->stockProductList('transfer', session()->get('showroom_id'), ShowRoom::class);
            $data = [
                'products' => $ProductList,
                'warehouses' => $this->wareHouseRepository->all(),
                'showrooms' => $this->showRoomRepository->all(),
            ];

            return view('inventory::stock_transfer.create')->with($data);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::success(trans('common.Something Went Wrong'), 'Error!');

            return back();
        }
    }

    public function store(StockTransferRequest $request)
    {
        DB::beginTransaction();

        try {
            $transfer = $this->stockTransferRepository->create($request->except('_token'));
            $user_id = null;
            $role_id = null;
            $subject = 'Stock Transfer Reminder';
            $class = $transfer;
            $data = "Transfer Has been Made From {$transfer->sendable->name} to {$transfer->receivable->name}";
            $url = route('stock-transfer.index');
            $this->sendNotification($class, null, $subject, null, null, $data, $user_id, $role_id, $url);
            DB::commit();
            LogActivity::successLog('Product Added To Transfer List');
            Toastr::success('Product Added To Transfer List', 'success!');

            return redirect()->route('stock-transfer.index');
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            DB::rollBack();
            Toastr::error('Operation Failed', 'Error!');

            return back();
        }
    }

    public function show($id)
    {
        try {
            $data = [
                'transfer' => $this->stockTransferRepository->find($id),
            ];

            return view('inventory::stock_transfer.show')->with($data);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::success('Something Went Wrong', 'Error!');

            return back();
        }
    }

    public function edit($id)
    {
        try {
            $transfer = $this->stockTransferRepository->find($id);

            $ProductList = $this->productRepository->stockProductList('transfer', $transfer->sendable_id, $transfer->sendable_type);

            $data = [
                'products' => $ProductList,
                'transfer' => $transfer,
                'warehouses' => $this->wareHouseRepository->all(),
                'showrooms' => $this->showRoomRepository->all(),
            ];

            return view('inventory::stock_transfer.edit')->with($data);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::success('Oops, Something Went Wrong', 'Error!');

            return back();
        }
    }

    public function update(StockTransferRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $this->stockTransferRepository->update($request->except('_token'), $id);
            DB::commit();
            LogActivity::successLog('Product Updated To Transfer List');
            Toastr::success('Product Updated To Transfer List Successfully', 'success!');

            return redirect()->route('stock-transfer.index');
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            DB::rollBack();
            Toastr::error('Operation Failed', 'Error!');

            return back();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $this->stockTransferRepository->delete($id);
            DB::commit();
            LogActivity::successLog('Product deleted from Transfer List');
            Toastr::success('Product deleted from Transfer List', 'Success!');

            return back();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            DB::rollBack();
            Toastr::success('Operation Failed', 'Error!');

            return back();
        }
    }

    //Ajax Request for storing products in stock Transfer list
    public function storeProduct(Request $request)
    {
        try {
            $productSku = $this->productRepository->findSku($request->id);
            $variantName = $this->variationRepository->variantName($productSku);

            $output = '';
            $type = $productSku->id . ",'sku'";
            $output .= '<tr>
                        <td><input type="hidden" name="product_id[]" value="' . $productSku->id . '" class="primary_input_field">' . $productSku->product->product_name . '</br>' . $variantName . '</td>

                        <td class="product_sku' . $productSku->id . '">' . $productSku->sku . '</td>

                        <td><input name="product_price[]" min="' . $productSku->purchase_price . '" onkeyup="priceCalc(' . $type . ')" class="primary_input_field product_price product_price_sku' . $productSku->id . '" type="number"
                        value="' . $productSku->purchase_price . '"></td>

                        <td>
                            <input type="number" name="quantity[]" value="1" onfocusout="addQuantity(' . $type . ')" class="primary_input_field quantity quantity_sku' . $productSku->id . '">
                        </td>

                        <td style="text-align:center" class="product_subtotal product_subtotal_sku' . $productSku->id . '">' . $productSku->purchase_price . '</td>
                        <td><a data-id="' . $productSku->id . '" class="delete_product primary-btn primary-circle fix-gr-bg" href="javascript:void(0)"><i class="ti-trash"></i></a></td>
                        </tr>

                        ';

            return response()->json($output);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());

            return response()->json(['error' => trans('common.Something Went Wrong')]);
        }
    }

    //Ajax Request for checking stock in pos,sale,
    public function checkQuantity(Request $request)
    {
        try {
            $msg = $this->productRepository->checkQuantity($request->all());

            return response()->json($msg);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());

            return response()->json(['error' => trans('common.Something Went Wrong')]);
        }
    }

    public function statusChange($id)
    {
        try {
            $this->stockTransferRepository->statusChange($id);
            Toastr::success('Stock Transfer Approve Successfully', 'Success!');

            return back();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Operation Failed', 'Error!');

            return back();
        }
    }

    public function sendToHouse($id)
    {
        DB::beginTransaction();

        try {
            $this->stockTransferRepository->sendToHouse($id);
            DB::commit();
            LogActivity::successLog('Stock Transfer Send Successfully');
            Toastr::success('Stock Transfer Send Successfully', 'Success!');

            return back();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            DB::rollBack();
            Toastr::error('Operation Failed', 'Error!');

            return back();
        }
    }

    public function stockReceive($id)
    {
        DB::beginTransaction();

        try {
            $transfer = $this->stockTransferRepository->stockReceive($id);
            DB::commit();
            if (is_numeric($transfer)) {
                Toastr::error('stock is limited', 'Error!');

                return back();
            }
            LogActivity::successLog('Stock Received Successfully');
            Toastr::success('Stock Received Successfully', 'Success!');

            return back();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            DB::rollBack();
            Toastr::error('Operation Failed', 'Error!');

            return back();
        }
    }

    public function productExist(Request $request)
    {
        $type = explode('-', $request->val);

        $house = $type[0] == 'warehouse' ? WareHouse::class : ShowRoom::class;

        $products = $this->productRepository->productList($type[1], $house);

        $output = '<option value="1">' . __('sale.Select Product') . '</option>';

        foreach ($products as $product) {
            $output .= '<option value="' . $product->product_id . '-' . $product->product_type . '">' . $product->product_name . '</option>';
        }

        return $output;
    }

    public function productInfo()
    {
        $stocks = $this->stockTransferRepository->allStockProduct();

        return view('inventory::stock_transfer.product_info', compact('stocks'));
    }

    //Ajax Product Modal Render for Products
    public function product_modal_for_select(Request $request)
    {
        try {
            $type = explode('-', $request->id);
            if ($type[1] == 'Single') {
                $data['product_id'] = $type[0];
                $data['product_type'] = $type[1];
            } elseif ($type[1] == 'Combo') {
                $data['product_id'] = $type[0];
                $data['product_type'] = $type[1];
            } else {
                $data['product_id'] = $type[0];
                $data['product_type'] = $type[1];

                $data['html'] = (string) view('sale::sale.product_details', [
                    'product' => $this->productRepository->find($type[0]),
                ]);
            }

            return response()->json($data);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());

            return response()->json(['error' => __('common.Something Went Wrong')]);
        }
    }

    public function getProducts(Request $request)
    {
        $house = explode('-', $request->id);
        if ($house[0] == 'warehouse') {
            $class = WareHouse::class;
        } else {
            $class = ShowRoom::class;
        }

        $output = '';
        $ProductList = $this->productRepository->stockProductList('transfer', $house[1], $class);

        $output .= '<option selected disabled>' . __('common.Select') . '</option>';
        foreach ($ProductList as $product) {
            $output .= '<option value="' . $product->product_id . '-' . $product->product_type . '">' . $product->product_name . '</option>';
        }

        return $output;
    }
}
