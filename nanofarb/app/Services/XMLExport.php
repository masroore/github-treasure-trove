<?php
/**
 * Created by PhpStorm.
 * User: its
 * Date: 30.07.19
 * Time: 16:35.
 */

namespace App\Services;

use App\Models\Shop\Product;
use App\Models\Taxonomy\Term;

class XMLExport
{
    protected $bladeTemplate;

    /**
     * XMLImport constructor.
     */
    public function __construct(string $bladeTemplate)
    {
        $this->bladeTemplate = $bladeTemplate;
    }

    public function render()
    {
        if (view()->exists($this->bladeTemplate)) {
            return view($this->bladeTemplate, [
                'products' => $this->getProducts(),
                'categories' => $this->getCategories(),
            ])->render();
        }
    }

    public function getCategories()
    {
        return Term::isPublish()->byVocabulary('product_categories')->get();
    }

    public function getProducts()
    {
        return Product::isPublish()->with('values.attribute')
            //->orderBy('product_group_id', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();
    }
}
