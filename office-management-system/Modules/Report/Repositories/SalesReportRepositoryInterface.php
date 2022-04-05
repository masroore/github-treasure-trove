<?php

namespace Modules\Report\Repositories;

interface SalesReportRepositoryInterface
{
    public function all();

    public function search($dateFrom, $dateTo, $showRoom_id, $retailer_id, $customer_id, $user_id, $type);

    public function searchProduct($dateFrom, $dateTo, $productSku_id);

    public function searchSalesReturn($showRoom_id, $retailer_id, $customer_id);

    public function accounts($from_date, $to_date, $customer_id);
}
