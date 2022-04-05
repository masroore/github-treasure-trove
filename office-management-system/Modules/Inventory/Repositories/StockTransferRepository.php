<?php

namespace Modules\Inventory\Repositories;

use Carbon\Carbon;
use Modules\Inventory\Entities\ShowRoom;
use Modules\Inventory\Entities\StockReport;
use Modules\Inventory\Entities\StockTransfer;
use Modules\Inventory\Entities\WareHouse;
use Modules\Product\Entities\ProductHistory;
use Modules\Product\Entities\ProductSku;
use Modules\Product\Repositories\ProductRepository;
use Modules\Purchase\Entities\ProductItemDetail;

class StockTransferRepository implements StockTransferRepositoryInterface
{
    public function all()
    {
        return StockTransfer::latest()->get();
    }

    public function allStockProduct()
    {
        return StockReport::with('productSku.product')->latest()->get();
    }

    public function allStockProductShowroom()
    {
        if (auth()->user()->role->type == 'system_user') {
            return ProductHistory::where('itemable_type', 'Modules\Inventory\Entities\ShowRoom')
                ->where('type', 'begining')
                ->with('itemable', 'stock')
                ->latest()
                ->get();
        }

        return ProductHistory::where('itemable_type', 'Modules\Inventory\Entities\ShowRoom')
            ->where('itemable_id', session()->get('showroom_id'))
            ->where('type', 'begining')
            ->with('itemable', 'stock')
            ->latest()
            ->get();
    }

    public function create(array $data)
    {
        $sender = explode('-', $data['from']);

        $receiver = explode('-', $data['to']);

        if ($sender[0] == 'warehouse') {
            $from = WareHouse::find($sender[1]);
        } else {
            $from = ShowRoom::find($sender[1]);
        }

        if ($receiver[0] == 'warehouse') {
            $to = WareHouse::find($receiver[1]);
        } else {
            $to = ShowRoom::find($receiver[1]);
        }

        $documents = [];
        if (!empty($data['documents'])) {
            foreach ($data['documents'] as $file) {
                $name = uniqid() . $file->getClientOriginalName();
                $file->move(public_path() . '/uploads/stock_transfer/', $name);
                $documents[] = '/uploads/stock_transfer/' . $name;
            }
        }

        $transfer = new StockTransfer([
            'date' => date('Y-m-d', strtotime($data['date'])),
            'notes' => $data['notes'],
            'documents' => $documents,
            'receivable_id' => $to->id,
            'receivable_type' => get_class($to),
        ]);

        $from->sends()->save($transfer);

        if (!empty($data['product_id'])) {
            foreach ($data['product_id'] as $key => $id) {
                $price = $data['product_price'][$key];

                $sub_total = (($price * $data['quantity'][$key]));
                $product = new ProductItemDetail([
                    'product_sku_id' => $data['product_id'][$key],
                    'price' => $price,
                    'quantity' => $data['quantity'][$key],
                    'sub_total' => $sub_total,
                    'productable_id' => $data['product_id'][$key],
                    'productable_type' => get_class(new ProductSku()),
                ]);
                $transfer->items()->save($product);
            }
        }

        return $transfer;
    }

    public function find($id)
    {
        return StockTransfer::findOrFail($id);
    }

    public function update(array $data, $id): void
    {
        $sender = explode('-', $data['from']);

        $receiver = explode('-', $data['to']);

        if ($sender[0] == 'warehouse') {
            $from = WareHouse::find($sender[1]);
        } else {
            $from = ShowRoom::find($sender[1]);
        }

        if ($receiver[0] == 'warehouse') {
            $to = WareHouse::find($receiver[1]);
        } else {
            $to = ShowRoom::find($receiver[1]);
        }

        $documents = [];
        if (!empty($data['documents'])) {
            foreach ($data['documents'] as $file) {
                $name = uniqid() . $file->getClientOriginalName();
                $file->move(public_path() . '/uploads/stock_transfer/' . $name);
                $documents[] = '/uploads/stock_transfer/' . $name;
            }
        }

        $transfer = StockTransfer::find($id);
        $transfer->date = date('Y-m-d', strtotime($data['date']));
        $transfer->notes = $data['notes'];
        $transfer->documents = $documents;
        $transfer->receivable_id = $to->id;
        $transfer->sendable_id = $from->id;
        $transfer->receivable_type = get_class($to);
        $transfer->sendable_type = get_class($to);
        $transfer->save();

        if (!empty($data['items'])) {
            foreach ($data['items'] as $key => $cart) {
                $productSku = ProductItemDetail::where('itemable_id', $transfer->id)->where('itemable_type', get_class(new StockTransfer()))
                    ->where('productable_type', get_class(new ProductSku()))->where('product_sku_id', $data['items'][$key])->first();
                if ($productSku) {
                    $sub_total = ($data['item_price'][$key] * $data['item_quantity'][$key]);

                    $productSku->update([
                        'price' => $data['item_price'][$key],
                        'quantity' => $data['item_quantity'][$key],
                        'sub_total' => $sub_total,
                    ]);
                }
            }
        }
        if (!empty($data['product_id'])) {
            foreach ($data['product_id'] as $key => $id) {
                $price = $data['product_price'][$key];

                $sub_total = (($price * $data['quantity'][$key]));
                $product = new ProductItemDetail([
                    'product_sku_id' => $data['product_id'][$key],
                    'price' => $price,
                    'quantity' => $data['quantity'][$key],
                    'sub_total' => $sub_total,
                    'productable_id' => $data['product_id'][$key],
                    'productable_type' => get_class(new ProductSku()),
                ]);
                $transfer->items()->save($product);
            }
        }
    }

    public function delete($id): void
    {
        $transfer = StockTransfer::find($id);

        $repo = new ProductRepository();
        foreach ($transfer->items as $item) {
            $repo->increaseQuantity($item->product_id, $item->quantity);
        }

        $transfer->delete();
    }

    public function statusChange($id)
    {
        return StockTransfer::where('id', $id)->update(['status' => 1]);
    }

    public function sendToHouse($id)
    {
        $transfer = StockTransfer::find($id);
        $transfer->sent_at = Carbon::now();
        $transfer->save();

        return $transfer;
    }

    public function stockReceive($id)
    {
        $error = 1;
        $transfer = StockTransfer::find($id);
        $house = $transfer->receivable;
        $to = $transfer->sendable;
        foreach ($transfer->items as $product) {
            $product_sku = $product->product_sku_id;
            $exists = $to->stocks()->where('product_sku_id', $product_sku)->first();
            if ($exists && $exists->stock >= $product->quantity) {
                $history = ProductHistory::where('type', 'purchase')->where('houseable_id', $product->itemable_id)->where('houseable_type', $product->itemable_type)
                    ->where('product_sku_id', $product->product_sku_id)->first();

                $increasedQuantity = $product->quantity - $product->return_quantity;
                $stock = $house->stocks()->where('product_sku_id', $product_sku)->first();
                if ($stock) {
                    $stock->update(['stock' => $stock->stock + $increasedQuantity]);
                } else {
                    StockReport::create([
                        'stock' => $increasedQuantity,
                        'product_sku_id' => $product->product_sku_id,
                        'houseable_id' => $transfer->receivable_id,
                        'houseable_type' => $transfer->receivable_type,
                    ]);
                }

                $exists->update([
                    'stock' => $exists->stock - $increasedQuantity,
                ]);
                if ($history) {
                    $history->status = 1;
                    $history->save();
                }
            } else {
                return $error;
            }
        }
        $transfer->received_at = Carbon::now();
        $transfer->save();

        return $transfer;
    }

    public function stockList()
    {
        return StockReport::with('productSku.product', 'houseable')->groupBy('houseable_id')->where('houseable_type', ShowRoom::class)->get();
    }

    public function stock($id)
    {
        return StockReport::with('productSku.item')->find($id);
    }

    public function suggestList()
    {
        if (session()->get('showroom_id') != 1) {
            return StockReport::with('suggestProducts')->where('houseable_type', 'Modules\Inventory\Entities\ShowRoom')
                ->where('houseable_id', session()->get('showroom_id'))->whereHas('suggestProducts', function ($query): void {
                    $query->whereColumn('alert_quantity', '>=', 'stock_reports.stock');
                })->latest()->get();
        } else {
            return StockReport::with('suggestProducts')->whereHas('suggestProducts', function ($query): void {
                $query->whereColumn('alert_quantity', '>=', 'stock_reports.stock');
            })->latest()->get();
        }
    }
}
