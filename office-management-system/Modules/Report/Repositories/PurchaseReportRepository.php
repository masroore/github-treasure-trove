<?php

namespace Modules\Report\Repositories;

use Carbon\Carbon;
use Modules\Inventory\Entities\ShowRoom;
use Modules\Inventory\Entities\WareHouse;
use Modules\Purchase\Entities\ProductItemDetail;
use Modules\Purchase\Entities\PurchaseOrder;
use Modules\Sale\Entities\Sale;

class PurchaseReportRepository implements PurchaseReportRepositoryInterface
{
    public function all()
    {
        return Sale::latest()->get();
    }

    public function search($showRoom_id, $supplier_id, $warehouse_id, $type)
    {
        $conditions = [];
        if ($showRoom_id != null) {
            $conditions = array_merge($conditions, ['purchasable_type' => get_class(new ShowRoom()), 'purchasable_id' => $showRoom_id]);
        } elseif (session()->has('showroom_id')) {
            if (auth()->user()->role->type == 'system_user') {
                $conditions = [];
            } else {
                $conditions = array_merge($conditions, ['purchasable_type' => get_class(new ShowRoom()), 'purchasable_id' => session()->get('showroom_id')]);
            }
        } else {
            $conditions = [];
        }
        if ($supplier_id != null) {
            $conditions = array_merge($conditions, ['supplier_id' => $supplier_id]);
        }
        if ($type != null) {
            $conditions = array_merge($conditions, ['status' => $type]);
        }
        if ($warehouse_id != null) {
            $conditions = array_merge($conditions, ['purchasable_type' => get_class(new WareHouse()), 'purchasable_id' => $warehouse_id]);
        }

        return PurchaseOrder::with('supplier', 'user', 'purchasable')->where($conditions)->where('status', 1)->latest()->get();
    }

    public function searchProduct($productSku_id)
    {
        $conditions = ['itemable_type' => PurchaseOrder::class];
        if ($productSku_id != null) {
            $conditions = array_merge($conditions, ['product_sku_id' => $productSku_id]);
        }

        return ProductItemDetail::with('itemable.purchasable', 'itemable.supplier')->whereHasMorph('itemable', PurchaseOrder::class, function ($query): void {
            $query->where('status', 1);
        })->where($conditions)->latest()->get();
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

        return Sale::where($conditions)->latest()->get();
    }

    public function purchaseHistory($product_sku, $house_id, $supplier_id, $status, $from_date, $to_date, $user_id)
    {
        $purchase = ProductItemDetail::query();
        if ($product_sku) {
            $purchase->where('product_sku_id', $product_sku)->where('itemable_type', PurchaseOrder::class);
        }
        if ($house_id) {
            $house = explode('-', $house_id);
            if ($house[1] == 'showroom') {
                $purchase->whereHasMorph('itemable', PurchaseOrder::class, function ($query) use ($house): void {
                    $query->where('purchasable_id', $house[0])->where('purchasable_type', ShowRoom::class);
                });
            } else {
                $purchase->whereHasMorph('itemable', PurchaseOrder::class, function ($query) use ($house): void {
                    $query->where('purchasable_id', $house[0])->where('purchasable_type', WareHouse::class);
                });
            }
        }
        if ($supplier_id) {
            $purchase->whereHasMorph('itemable', PurchaseOrder::class, function ($query) use ($supplier_id): void {
                $query->where('supplier_id', $supplier_id);
            });
        }
        if ($user_id) {
            $purchase->whereHasMorph('itemable', PurchaseOrder::class, function ($query) use ($user_id): void {
                $query->where('created_by', $user_id);
            });
        }

        $purchase->whereHasMorph('itemable', PurchaseOrder::class, function ($query): void {
            $query->where('status', 1);
        });

        if ($from_date) {
            $purchase->whereHasMorph('itemable', PurchaseOrder::class, function ($query) use ($from_date): void {
                $query->whereDate('created_at', '>=', Carbon::parse($from_date));
            });
        }
        if ($to_date) {
            $purchase->whereHasMorph('itemable', PurchaseOrder::class, function ($query) use ($to_date): void {
                $query->whereDate('created_at', '<=', Carbon::parse($to_date));
            });
        }

        return $purchase->with('itemable.purchasable', 'itemable.supplier')->latest()->get();
    }

    public function saleHistory($product_sku, $house_id, $customer_id, $status, $from_date, $to_date, $user_id)
    {
        $purchase = ProductItemDetail::query();

        if ($product_sku) {
            $purchase->where('product_sku_id', $product_sku)->where('itemable_type', Sale::class);
        }
        if ($house_id) {
            $house = explode('-', $house_id);
            if ($house[1] == 'showroom') {
                $purchase->whereHasMorph('itemable', Sale::class, function ($query) use ($house): void {
                    $query->where('saleable_id', $house[0])->where('saleable_type', ShowRoom::class);
                });
            } else {
                $purchase->whereHasMorph('itemable', Sale::class, function ($query) use ($house): void {
                    $query->where('saleable_id', $house[0])->where('saleable_type', WareHouse::class);
                });
            }
        }
        if ($customer_id) {
            $purchase->whereHasMorph('itemable', Sale::class, function ($query) use ($customer_id): void {
                $query->where('customer_id', $customer_id);
            });
        }
        if ($user_id) {
            $purchase->whereHasMorph('itemable', Sale::class, function ($query) use ($user_id): void {
                $query->where('customer_id', $user_id);
            });
        }

        $purchase->whereHasMorph('itemable', Sale::class, function ($query): void {
            $query->where('is_approved', 1);
        });

        if ($from_date) {
            $purchase->whereHasMorph('itemable', Sale::class, function ($query) use ($from_date): void {
                $query->whereDate('created_at', '<=', Carbon::parse($from_date));
            });
        }
        if ($to_date) {
            $purchase->whereHasMorph('itemable', Sale::class, function ($query) use ($to_date): void {
                $query->whereDate('created_at', '>=', Carbon::parse($to_date));
            });
        }

        return $purchase->with('itemable.saleable', 'itemable.customer')->latest()->get();
    }

    public function accounts($from_date, $to_date, $supplier_id)
    {
        $purchase = PurchaseOrder::query();

        if (isset($supplier_id)) {
            $purchase->where('supplier_id', $supplier_id);
        }
        if (isset($from_date)) {
            $purchase->whereDate('date', '>=', Carbon::parse($from_date));
        }
        if (isset($to_date)) {
            $purchase->whereDate('date', '<=', Carbon::parse($to_date));
        }

        return $purchase->with('supplier')->where('status', 1)->paginate(10);
    }
}
