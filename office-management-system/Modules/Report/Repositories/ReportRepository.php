<?php

namespace Modules\Report\Repositories;

use Carbon\Carbon;
use Modules\Account\Entities\TypeOpeningBalance;
use Modules\Inventory\Entities\ShowRoom;
use Modules\Inventory\Entities\WareHouse;
use Modules\Packing\Entities\PackingItemDetail;
use Modules\Packing\Entities\PackingOrder;
use Modules\Packing\Entities\PackingOrderRecieveHistory;
use Modules\Product\Entities\PartNumber;

class ReportRepository implements ReportRepositoryInterface
{
    public function all()
    {
        return TypeOpeningBalance::with('chartAccount')->latest()->get();
    }

    public function serialAll()
    {
        return PartNumber::with('product_sku', 'product_item_details_part_number')->get();
    }

    public function search($type)
    {
        return TypeOpeningBalance::where(['type' => $type])->with('chartAccount')->latest()->get();
    }

    public function packing($house_id, $supplier_id, $from_date, $to_date, $receive)
    {
        $packings = PackingOrder::query();

        if (isset($house_id)) {
            $type = explode('-', $house_id);
            if ($type[1] == 'warehouse') {
                $house = WareHouse::class;
            } else {
                $house = ShowRoom::class;
            }

            $packings->where('packable_id', $house_id)->where('packable_type', $house);
        }
        if (isset($supplier_id)) {
            $packings->where('supplier_id', $supplier_id);
        }

        if (isset($from_date)) {
            $packings->whereDate('date', '>=', Carbon::parse($from_date));
        }
        if (isset($receive)) {
            $packings->where('recieved_status', $receive);
        }
        if (isset($to_date)) {
            $packings->whereDate('date', '<=', Carbon::parse($to_date));
        }

        return $packings->with('supplier', 'packable')->where('status', 1)->get();
    }

    public function packingSearch($product_sku_id, $from_date, $to_date)
    {
        $items = PackingItemDetail::query();

        if (isset($product_sku_id)) {
            $items->where('product_sku_id', $product_sku_id);
        }
        if (isset($from_date)) {
            $items->whereDate('created_at', '>=', Carbon::parse($from_date));
        }
        if (isset($to_date)) {
            $items->whereDate('created_at', '<=', Carbon::parse($to_date));
        }

        return $items->with('packing_order.supplier', 'packing_order.packable')->Active()->get();
    }

    public function packingRcvSearch($product_sku_id, $from_date, $to_date)
    {
        $items = PackingOrderRecieveHistory::query();

        if (isset($product_sku_id)) {
            $items->where('product_sku_id', $product_sku_id);
        }
        if (isset($from_date)) {
            $items->whereDate('created_at', '>=', Carbon::parse($from_date));
        }
        if (isset($to_date)) {
            $items->whereDate('created_at', '<=', Carbon::parse($to_date));
        }

        return $items->with('packing_order')->get();
    }
}
