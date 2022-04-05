<?php

namespace Modules\Purchase\Repositories;

interface PurchaseOrderRepositoryInterface
{
    public function all();

    public function create(array $data);

    public function find($id);

    public function update(array $data, $id);

    public function approve($id);

    public function delete($id);

    public function itemList();

    public function itemUpdate(array $data, $id);

    public function returnApprove($id);

    public function payments(array $data, $id);

    public function addToStock($id, array $data);

    public function adToStockOpening(array $data);

    public function approvePurchase();

    public function purchasePayments($type);

    public function purchaseDue($type);

    public function supplierProducts($supplier);
}
