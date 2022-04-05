<?php

namespace Modules\Product\Repositories;

interface VariantRepositoryInterface
{
    public function all();

    public function serachBased($search_keyword);

    public function create(array $data);

    public function find($id);

    public function update(array $data, $id);

    public function delete($id);

    public function variantValues($variant);

    public function variantWithValues($variant);

    public function variantName($productSku);

    public function comboVariant($productCombo);
}
