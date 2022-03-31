<?php

namespace App\Models\Front\Category;

use App\Models\CategoryMenu;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
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

    public function parent()
    {
        return $this->hasOne(self::class, 'id', 'parent_id');
    }

    public function subcategories()
    {
        return $this->where('parent_id', $this->id)->orderBy('sort_order', 'asc')->get();
    }

    /**
     * Get the categories for the
     * navigation menu.
     */
    public static function getList()
    {
        return (new CategoryMenu())->list();
    }

    /**
     * Get the categories menu.
     * List for the select component.
     *
     * @param bool $admin
     */
    public static function getMenu($admin = false)
    {
        return (new CategoryMenu())->menu($admin);
    }
}
