<?php

namespace App\Models;

use Agmedia\Category\Facades\Category as Categories;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Category extends Model
{
    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Get the categories for the
     * navigation menu.
     */
    public static function getList()
    {
        $cat = new \Agmedia\Category\Category();

        return $cat->getList();
    }

    /**
     * Get the categories menu.
     * List for the select component.
     */
    public static function getMenu()
    {
        $cat = new \Agmedia\Category\Category();

        return $cat->menu();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public static function parents()
    {
        return DB::table('categories')->where('parent_id', '==', '')->pluck('name', 'id');
    }

    /**
     * Store new category.
     */
    public static function store(Request $request)
    {
        $top = (isset($request->top) && 'on' == $request->top) ? 1 : 0;
        $parent = (!$top && isset($request->parent) && 'on' == $request->parent) ? (int) ($request->parent) : 0;

        $id = self::insertGetId([
            'name' => $request->name,
            'description' => $request->description,
            'meta_description' => $request->meta_description,
            'meta_keyword' => $request->meta_keyword,
            'parent_id' => $parent,
            'top' => $top,
            'status' => (isset($request->status) && 'on' == $request->status) ? 1 : 0,
            'slug' => Str::slug($request->name),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        if ($id) {
            return self::find($id);
        }

        return false;
    }

    /**
     * Update category.
     *
     * @param $category
     */
    public static function edit(Request $request, $category)
    {
        $top = (isset($request->top) && 'on' == $request->top) ? 1 : 0;
        $parent = (!$top && isset($request->parent) && 'on' == $request->parent) ? (int) ($request->parent) : 0;

        $updated = self::where('id', $category->id)->update([
            'name' => $request->name,
            'description' => $request->description,
            'meta_description' => $request->meta_description,
            'meta_keyword' => $request->meta_keyword,
            'parent_id' => $parent,
            'top' => $top,
            'status' => (isset($request->status) && 'on' == $request->status) ? 1 : 0,
            'slug' => Str::slug($request->name),
            'updated_at' => Carbon::now(),
        ]);

        if ($updated) {
            return self::find($category->id);
        }

        return false;
    }

    /**
     * @param $blog
     * @param $path
     */
    public static function updateImagePath($category, $path)
    {
        return self::where('id', $category->id)->update([
            'image' => $path,
        ]);
    }

    /**
     * @param $id
     */
    public static function withSubDestroy($id)
    {
        $category = self::find($id);

        // If it's a Top Category
        if (!$category['parent_id']) {
            self::where('parent_id', $id)->delete();
        }

        return self::where('id', $id)->delete();
    }
}
