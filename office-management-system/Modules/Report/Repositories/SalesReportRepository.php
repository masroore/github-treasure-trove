<?php

namespace Modules\Report\Repositories;

use Carbon\Carbon;
use Modules\Inventory\Entities\ShowRoom;
use Modules\Purchase\Entities\ProductItemDetail;
use Modules\Sale\Entities\Sale;

class SalesReportRepository implements SalesReportRepositoryInterface
{
    public function all()
    {
        return Sale::latest()->get();
    }

    public function search($dateFrom, $dateTo, $showRoom_id, $retailer_id, $customer_id, $user_id, $type)
    {
        $conditions = [];
        if ($showRoom_id != null) {
            $conditions = array_merge($conditions, ['saleable_type' => ShowRoom::class, 'saleable_id' => $showRoom_id]);
        } else {
            if (auth()->user()->role->type == 'system_user') {
                $conditions = [];
            } else {
                $conditions = array_merge($conditions, ['saleable_type' => ShowRoom::class, 'saleable_id' => session()->get('showroom_id')]);
            }
        }
        if ($type != null) {
            $conditions = array_merge($conditions, ['type' => $type]);
        }
        if ($retailer_id != null) {
            $conditions = array_merge($conditions, ['agent_user_id' => $retailer_id]);
        }
        if ($customer_id != null) {
            $conditions = array_merge($conditions, ['customer_id' => $customer_id]);
        }
        if ($user_id != null) {
            $conditions = array_merge($conditions, ['user_id' => $user_id]);
        }

        if ($dateFrom != null && $dateTo != null) {
            $results = Sale::with('user', 'customer', 'saleable')->whereBetween('date', [$dateFrom, $dateTo])->where($conditions)->where('is_approved', 1)->latest()->get();
        } else {
            $results = Sale::with('user', 'customer', 'saleable')->where($conditions)->where('is_approved', 1)->latest()->get();
        }

        return $results;
    }

    public function searchProduct($dateFrom, $dateTo, $productSku_id)
    {
        $conditions = ['itemable_type' => get_class(new Sale())];
        if ($productSku_id != null) {
            $conditions = array_merge($conditions, ['product_sku_id' => $productSku_id]);
        }
        if ($dateFrom != null && $dateTo != null) {
            $results = ProductItemDetail::whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])->where($conditions)->latest()->get();
        } else {
            $results = ProductItemDetail::with('itemable.saleable', 'itemable.customer', 'itemable.agentuser', 'itemable.user', 'itemable.saleable')
                ->where($conditions)->latest()->get();
        }

        return $results;
    }

    public function searchSalesReturn($showRoom_id, $retailer_id, $customer_id)
    {
        $conditions = ['return_status' => 1];
        if ($showRoom_id != null) {
            $conditions = array_merge($conditions, ['saleable_type' => ShowRoom::class, 'saleable_id' => $showRoom_id]);
        } else {
            $conditions = array_merge($conditions, ['saleable_type' => ShowRoom::class, 'saleable_id' => session()->get('showroom_id')]);
        }
        if ($retailer_id != null) {
            $conditions = array_merge($conditions, ['agent_user_id' => $retailer_id]);
        }
        if ($customer_id != null) {
            $conditions = array_merge($conditions, ['customer_id' => $customer_id]);
        }

        return Sale::with('customer', 'agentuser', 'items', 'saleable', 'user')->where($conditions)->latest()->get();
    }

    public function accounts($from_date, $to_date, $customer_id)
    {
        $sale = Sale::query();

        if (isset($customer_id)) {
            $sale->where('customer_id', $customer_id);
        }
        if (isset($from_date)) {
            $sale->whereDate('date', '>=', Carbon::parse($from_date));
        }
        if (isset($to_date)) {
            $sale->whereDate('date', '<=', Carbon::parse($to_date));
        }

        return $sale->with('customer', 'payments')->where('is_approved', 1)->paginate(10);
    }
}
