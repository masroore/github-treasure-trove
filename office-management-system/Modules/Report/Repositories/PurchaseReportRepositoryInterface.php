<?php

namespace Modules\Report\Repositories;

interface PurchaseReportRepositoryInterface
{
    public function all();

    public function search($showRoom_id, $supplier_id, $warehouse_id, $type);

    public function searchProduct($productSku_id);

    public function searchSalesReturn($showRoom_id, $retailer_id, $customer_id);

    public function purchaseHistory($product_sku, $house_id, $supplier_id, $status, $from_date, $to_date, $user_id);

    public function saleHistory($product_sku, $house_id, $customer_id, $status, $from_date, $to_date, $user_id);

    public function accounts($from_date, $to_date, $supplier_id);
}
