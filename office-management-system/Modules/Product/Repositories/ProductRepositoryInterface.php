<?php

namespace Modules\Product\Repositories;

interface ProductRepositoryInterface
{
    public function all();

    public function service();

    public function allStockProduct();

    public function allComboProduct();

    public function searchBased($search_keyword);

    public function searchCombo($value);

    public function getPrice($ids, $purchasePrice, $sellPrice);

    public function create(array $data);

    public function find($id);

    public function findCombo($id);

    public function findSku($id);

    public function update(array $data, $id);

    public function delete($id);

    public function deleteCombo($id);

    public function decreaseQuantity($id, $quantity);

    public function increaseQuantity($id, $quantity);

    public function checkQuantity($data);

    public function checkNumberofQuantity($data);

    public function searchProduct($data);

    public function productList($id, $type);

    public function stockProductList($type, $id, $house);

    public function productForPurchase();

    public function stockAlert($type);

    public function csv_upload_single_product($data);
}
