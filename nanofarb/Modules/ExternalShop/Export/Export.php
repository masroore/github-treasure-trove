<?php

namespace Modules\ExternalShop\Export;

use App\Models\Shop\Product;
use App\Models\Taxonomy\Term;

class Export
{
    protected $blade = 'externalshop::export-xml';

    public function render()
    {
        if (view()->exists($this->blade)) {
            return view($this->blade, [
                'products' => $this->getProducts(),
                'categories' => $this->getCategories(),
            ])->render();
        }
    }

    public function getCategories()
    {
        return Term::isPublish()
            ->byVocabulary('product_categories')
            ->byLocale()
            ->get();
    }

    public function getProducts()
    {
        return Product::isPublish()
            ->withBase()
            ->byLocale()
            ->with('values.attribute')
            //->orderBy('product_group_id', 'asc')
            //->orderBy('created_at', 'asc')
            ->get();
    }
}
