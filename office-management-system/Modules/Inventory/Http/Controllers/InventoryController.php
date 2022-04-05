<?php

namespace Modules\Inventory\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Routing\Controller;
use LogActivity;
use Modules\Product\Entities\ProductHistory;
use Modules\Purchase\Entities\CostOfGoodHistory;

class InventoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        try {
            $items = ProductHistory::latest()->get();

            return view('inventory::product_movements.index', compact('items'));
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Operation failed');

            return back();
        }
    }

    public function cost_of_goods_index()
    {
        try {
            $cost_of_goods = CostOfGoodHistory::with('productSku', 'productSku.product', 'productSku.product.unit_type', 'costable', 'storeable')
                ->latest()->get();

            return view('inventory::cost_of_goods.index', compact('cost_of_goods'));
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(trans('common.Something Went Wrong'));

            return back();
        }
    }
}
