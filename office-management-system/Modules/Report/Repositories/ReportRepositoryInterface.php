<?php

namespace Modules\Report\Repositories;

interface ReportRepositoryInterface
{
    public function all();

    public function search($type);

    public function packing($house_id, $supplier_id, $from_date, $to_date, $receive);

    public function packingSearch($product_sku_id, $from_date, $to_date);

    public function packingRcvSearch($product_sku_id, $from_date, $to_date);

    public function serialAll();
}
