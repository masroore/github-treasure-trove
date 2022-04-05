<?php

namespace Modules\Product\Repositories;

use Illuminate\Support\Arr;
use Modules\Product\Entities\Category;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function all()
    {
        return Category::with('categories', 'parentCat')
            ->orderBy('id', 'DESC')
            ->get();
    }

    public function serachBased($search_keyword)
    {
        return Category::whereLike(['name', 'code', 'parent_id'], $search_keyword)->get();
    }

    public function create(array $data): void
    {
        $category = new Category();
        if (isset($data['as_sub_category']) && $data['as_sub_category'] == 1) {
            $parent_account = $this->find($data['parent_id']);
            $data = Arr::add($data, 'level', $parent_account ? ($parent_account->level + 1) : 1);
            $data = Arr::add($data, 'parent_id', $data['parent_id']);
        } else {
            $data = Arr::add($data, 'level', 0);
            $data = Arr::set($data, 'parent_id', null);
        }
        $category->fill($data)->save();
    }

    public function find($id)
    {
        return Category::findOrFail($id);
    }

    public function update(array $data, $id): void
    {
        $variant = Category::findOrFail($id);
        if (isset($data['as_sub_category']) && $data['as_sub_category'] == 1) {
            $data = Arr::add($data, 'parent_id', $data['parent_id']);
        } else {
            $data = Arr::set($data, 'parent_id', null);
        }
        $variant->update($data);
    }

    public function category()
    {
        return Category::where('parent_id', null)->get();
    }

    public function subcategory($category)
    {
        return Category::where('parent_id', $category)->get();
    }

    public function allSubCategory()
    {
        return Category::where('parent_id', '!=', null)->get();
    }

    public function delete($id)
    {
        return Category::findOrFail($id)->delete();
    }
}
