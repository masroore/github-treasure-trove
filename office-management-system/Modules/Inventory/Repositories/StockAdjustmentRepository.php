<?php

namespace Modules\Inventory\Repositories;

use Carbon\Carbon;
use Modules\Inventory\Entities\ShowRoom;
use Modules\Inventory\Entities\StockAdjustment;
use Modules\Inventory\Entities\StockAdjustmentProduct;
use Modules\Inventory\Entities\StockReport;
use Modules\Inventory\Entities\WareHouse;
use Modules\Product\Entities\ProductHistory;
use Modules\Product\Entities\ProductSku;

class StockAdjustmentRepository implements StockAdjustmentRepositoryInterface
{
    public function all()
    {
        return StockAdjustment::latest()->get();
    }

    public function create(array $data): void
    {
        $type = explode('-', $data['warehouse_id']);
        if ($type[0] == 'warehouse') {
            $w = WareHouse::find($type[1]);
        } else {
            $w = ShowRoom::find($type[1]);
        }
        $stock_adjustment = new StockAdjustment();
        $stock_adjustment->ref_no = $data['ref_no'];
        $stock_adjustment->recovery_amount = $data['recovery_amount'];
        $stock_adjustment->date = date('Y-m-d', strtotime($data['date']));
        $stock_adjustment->reason = $data['notes'];
        $stock_adjustment->adjustable_id = $w->id;
        $stock_adjustment->adjustable_type = get_class($w);
        $stock_adjustment->save();
        if (!empty($data['product_id'])) {
            foreach ($data['product_id'] as $key => $id) {
                $price = ProductSku::find($id)->purchase_price;
                $sub_total = $price * $data['product_quantity'][$key];
                $stock_adjustment_product = new StockAdjustmentProduct();
                $stock_adjustment_product->stock_adjustment_id = $stock_adjustment->id;
                $stock_adjustment_product->unit_price = $price;
                $stock_adjustment_product->product_sku_id = $data['product_id'][$key];
                $stock_adjustment_product->qty = $data['product_quantity'][$key];
                $stock_adjustment_product->subtotal = $sub_total;
                $stock_adjustment_product->save();
                $productHistory = new ProductHistory([
                    'type' => 'stock_adjustment',
                    'date' => Carbon::now()->toDateString(),
                    'in_out' => $data['product_quantity'][$key],
                    'product_sku_id' => $data['product_id'][$key],
                    'itemable_id' => $w->id,
                    'itemable_type' => get_class($w),
                ]);
                $stock_adjustment->houses()->save($productHistory);
            }
        }
    }

    public function find($id)
    {
        return StockAdjustment::findOrFail($id);
    }

    public function update(array $data, $id): void
    {
        $type = explode('-', $data['warehouse_id']);
        if ($type[0] == 'warehouse') {
            $w = WareHouse::find($type[1]);
        } else {
            $w = ShowRoom::find($type[1]);
        }
        $stock_adjustment = StockAdjustment::find($id);
        $stock_adjustment->ref_no = $data['ref_no'];
        $stock_adjustment->recovery_amount = $data['recovery_amount'];
        $stock_adjustment->date = date('Y-m-d', strtotime($data['date']));
        $stock_adjustment->reason = $data['notes'];
        $stock_adjustment->adjustable_id = $w->id;
        $stock_adjustment->adjustable_type = get_class($w);
        $stock_adjustment->save();
        foreach ($stock_adjustment->houses as $productHistory) {
            $productHistory->delete();
        }
        foreach ($stock_adjustment->stock_adjustments_products as $stock_adjustments_product) {
            $stock_adjustments_product->delete();
        }

        if (!empty($data['product_id'])) {
            foreach ($data['product_id'] as $key => $id) {
                $price = ProductSku::find($id)->purchase_price;
                $sub_total = $price * $data['product_quantity'][$key];
                $stock_adjustment_product = new StockAdjustmentProduct();
                $stock_adjustment_product->stock_adjustment_id = $stock_adjustment->id;
                $stock_adjustment_product->unit_price = $price;
                $stock_adjustment_product->product_sku_id = $data['product_id'][$key];
                $stock_adjustment_product->qty = $data['product_quantity'][$key];
                $stock_adjustment_product->subtotal = $sub_total;
                $stock_adjustment_product->save();
                $productHistory = new ProductHistory([
                    'type' => 'stock_adjustment',
                    'date' => Carbon::now()->toDateString(),
                    'in_out' => $data['product_quantity'][$key],
                    'product_sku_id' => $data['product_id'][$key],
                    'itemable_id' => $w->id,
                    'itemable_type' => get_class($w),
                ]);
                $stock_adjustment->houses()->save($productHistory);
            }
        }
    }

    public function delete($id)
    {
        $stock_adjustment = StockAdjustment::find($id);
        foreach ($stock_adjustment->houses as $history) {
            $history->delete();
        }
        foreach ($stock_adjustment->stock_adjustments_products as $stock_adjustments_product) {
            $stock_adjustments_product->findOrFail($stock_adjustments_product->id)->delete();
        }
        $stock_adjustment->status = 1;
        $stock_adjustment->save();

        return StockAdjustment::findOrFail($id)->delete();
    }

    public function statusChange($id): void
    {
        $stock_adjustment = StockAdjustment::find($id);
        foreach ($stock_adjustment->houses as $history) {
            $history->status = 1;
            $history->save();
            $stocks = StockReport::where('houseable_type', $history->itemable_type)->where('houseable_id', $history->itemable_id)->where('product_sku_id', $history->product_sku_id)->first();
            $stocks->stock -= $history->in_out;
            $stocks->save();
        }
        $stock_adjustment->status = 1;
        $stock_adjustment->save();
    }

    public function checkQuantity($data)
    {
        $type = explode('-', $data['house']);
        if ($type[0] == 'warehouse') {
            $house = WareHouse::find($type[1]);
        } else {
            $house = ShowRoom::find($type[1]);
        }

        return $house->stocks()->where('product_sku_id', $data['id'])->first();
    }
}
