<?php

namespace Modules\Sale\Repositories;

interface SaleRepositoryInterface
{
    public function all();

    public function approvedSales();

    public function create(array $data);

    public function acceptOrder(array $data);

    public function find($id);

    public function statusChange($id);

    public function returnApprove($id);

    public function update(array $data, $id);

    public function delete($id);

    public function itemList();

    public function itemUpdate(array $data, $item, $id);

    public function itemDelete($id);

    public function customerDetails(array $data);

    public function payments(array $data, $id);

    public function customerDues($customer_id, $sale_id);

    public function quotationToSale($data);

    public function storeShipping(array $data);

    public function customerInvoiceList($customer_id);

    public function retailerInvoiceList($user_id);

    public function salePayments($type);

    public function saleDue($type);

    public function monthlySales();

    public function dailySales();

    public function monthlyShowroomSales();

    public function yearlyShowroomSales();

    public function dueList($type);

    public function saleTotalPayments($type);
}
