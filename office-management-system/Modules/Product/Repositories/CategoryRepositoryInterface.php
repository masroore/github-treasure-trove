<?php

namespace Modules\Product\Repositories;

interface CategoryRepositoryInterface
{
    public function all();

    public function serachBased($search_keyword);

    public function create(array $data);

    public function find($id);

    public function update(array $data, $id);

    public function delete($id);

    public function category();

    public function subcategory($category);

    public function allSubCategory();
}
