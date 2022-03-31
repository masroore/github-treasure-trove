<?php

namespace App\Models\Front\Category;

use App\Models\Front\Product;
use App\Models\Front\Product\CategoryProduct;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    /**
     * @var string
     */
    protected $table = 'categories';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function products()
    {
        return $this->hasManyThrough(Product::class, CategoryProduct::class, 'category_id', 'id', 'id', 'product_id')->with('action')->paginate();
    }
}
