<?php

namespace App\Models\Front;

use App\Models\Back\Design\WidgetGroup;
use App\Models\Back\Settings\PageBlock;
use App\Models\Front\Category\Category;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    /**
     * @var string
     */
    protected $table = 'pages';

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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function blocks()
    {
        return $this->hasMany(PageBlock::class, 'page_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cat()
    {
        return $this->belongsTo(Category::class, 'category_id')->where('parent_id', 0);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subcat()
    {
        return $this->belongsTo(Category::class, 'category_id')->where('parent_id', '!=', 0);
    }

    /**
     * @param $query
     */
    public function scopePublished($query)
    {
        return $query->where('status', 1)->where('publish_date', '<=', now())->orWhere('publish_date', '0000-00-00 00:00:00');
    }

    /**
     * @param $query
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * @param $query
     * @param $category
     */
    public function scopeArticle($query, $category)
    {
        return $query->where('category_id', $category->id);
    }

    /**
     * @param $query
     * @param $category
     */
    public function scopeNews($query, $category)
    {
        if ($category->subcategories()->count()) {
            $ids = [];
            foreach ($category->subcategories() as $sub) {
                $ids[] = $sub->id;
            }

            return $query->whereIn('category_id', $ids);
        }

        return $query->where('category_id', $category->id);
    }

    /**
     * @param $query
     * @param $term
     */
    public function scopeSearch($query, $term)
    {
        $term = addslashes($term);

        return $query->where('name', 'LIKE', "%{$term}%")->orWhere('meta_keywords', 'LIKE', "%{$term}%");
    }

    public function setDescription()
    {
        $iterator = substr_count($this->description, '++');
        $offset = 0;
        $ids = [];

        for ($i = 0; $i < $iterator / 2; $i++) {
            $from = strpos($this->description, '++', $offset) + 2;
            $to = strpos($this->description, '++', $from + 2);
            $ids[] = substr($this->description, $from, $to - $from);

            $offset = $to + 2;
        }

        foreach ($ids as $id) {
            $wg = WidgetGroup::where('id', $id)->orWhere('slug', $id)->where('status', 1)->with('widgets')->first();

            $this->description = str_replace(
                '++' . $id . '++',
                view('front.layouts.widgets.widget_' . $wg->section_id, ['data' => $wg->widgets]),
                $this->description
            );
        }
    }
}
