<?php

namespace Agmedia\Category;

use Illuminate\Support\Facades\DB;

class Category
{
    /**
     * @var string category group
     */
    public $group;

    /**
     * @var DB Object - Collection
     */
    public $categories;

    /**
     * Category constructor.
     *
     * @param string $group
     */
    public function __construct($group = 'top')
    {
        $this->group = $group;
    }

    /**
     * Get the top main menu.
     */
    public function menu()
    {
        $this->resolveGroup();
        $subs = [];
        $menu = [];

        foreach ($this->categories as $key => $category) {
            if (!$key) {
                $subs = [];

                foreach ($category as $index => $value) {
                    if (isset($this->categories[$value->id])) {
                        $value->subcategory = $this->categories[$value->id];

                        if ($value->top) {
                            $subs[] = $value;
                        }
                    } else {
                        if ($value->top) {
                            $value->subcategory = null;
                            $subs[] = $value;
                        }
                    }
                }
            }
        }

        foreach ($subs as $sub) {
            $menu[] = [
                'id' => $sub->id,
                'name' => $sub->name,
                'slug' => /*'toyota-vilicari/' . */ $sub->slug,
                'parent_id' => $sub->parent_id,
            ];

            if (isset($sub->subcategory)) {
                foreach ($sub->subcategory as $value) {
                    $menu[] = [
                        'id' => $value->id,
                        'name' => $sub->name . ' > ' . $value->name,
                        'slug' => /*'toyota-vilicari/' . */ $sub->slug . '/' . $value->slug,
                        'parent_id' => $value->parent_id,
                    ];
                }
            }
        }

        return $menu;
    }

    /**
     * Get the admin top main menu.
     */
    public function getList()
    {
        $this->resolveGroup();
        $subs = [];
        $_total = 0;

        foreach ($this->categories as $key => $category) {
            if (!$key) {
                $subs = [];

                foreach ($category as $index => $value) {
                    //dd($this->categories, $value);
                    if (isset($this->categories[$value->id])) {
                        $value->subcategory = $this->categories[$value->id];
                        $value->subcategory_count = \count($this->categories[$value->id]);

                        if ($value->top) {
                            $subs[] = $value;
                        }

                        $_total += $value->subcategory_count;
                    } else {
                        if ($value->top) {
                            $value->subcategory = null;
                            $value->subcategory_count = 0;
                            $subs[] = $value;
                        }
                    }
                }
            }
        }

        return [
            'list' => $subs,
            'count' => $_total + \count($subs),
        ];
    }

    /**
     * @private
     * Resolve the needed group of categories
     */
    private function resolveGroup()
    {
        if ('top' == $this->group) {
            $this->categories = DB::table('categories')->where('status', 1)->orderBy('sort_order')->get()->groupBy('parent_id');
        }
    }
}
