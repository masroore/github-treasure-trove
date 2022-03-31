<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CategoryMenu extends Model
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
    public function list($with_top = true, $with_singles = false)
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
            if ($with_top) {
                $menu[] = [
                    'id' => $sub->id,
                    'name' => $sub->name,
                    'slug' => $sub->slug,
                    'single_page' => $sub->single_page,
                    'parent_id' => $sub->parent_id,
                    'group' => $sub->group,
                ];
            }

            if ($with_singles && $sub->single_page) {
                $menu[] = [
                    'id' => $sub->id,
                    'name' => $sub->name,
                    'slug' => $sub->slug,
                    'single_page' => $sub->single_page,
                    'parent_id' => $sub->parent_id,
                    'group' => $sub->group,
                ];
            }

            if (isset($sub->subcategory)) {
                foreach ($sub->subcategory as $value) {
                    $menu[] = [
                        'id' => $value->id,
                        'name' => $sub->name . ' > ' . $value->name,
                        'slug' => $sub->slug . '/' . $value->slug,
                        'single_page' => $value->single_page,
                        'parent_id' => $value->parent_id,
                        'group' => $value->group,
                    ];
                }
            }
        }

        return $menu;
    }

    /**
     * Get the admin top main menu.
     *
     * @param bool $admin
     */
    public function menu($admin = false)
    {
        $admin ? $this->resolveAdminGroup() : $this->resolveGroup();
        $subs = [];
        $_total = 0;

        foreach ($this->categories as $key => $category) {
            if (!$key) {
                $subs = [];

                foreach ($category as $index => $value) {
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
            'list' => collect($subs)->groupBy('group')->toArray(),
            'admin_list' => $subs,
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

    /**
     * @private
     * Resolve the needed group of categories
     */
    private function resolveAdminGroup()
    {
        if ('top' == $this->group) {
            $this->categories = DB::table('categories')->orderBy('sort_order')->get()->groupBy('parent_id');
        }
    }
}
