<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;

class Category extends Model
{
    protected $table = 'category';

    protected $fillable = [
        'category',
        'color',
        'text_color',
        'status',
    ];

    protected $casts = [
        'category' => 'string',
        'color' => 'string',
        'text_color' => 'string',
        'status' => 'boolean',
    ];

    public function relatedPosts()
    {
        return $this->hasManyThrough(
            \App\Models\Blog::class,
            \App\Models\BlogCategory::class,
            '',
            'id',
            '',
            'blog_id'
        )->where('blog.status', 1)
            ->orderBy('blog.id', 'desc')
            ->limit(3);
    }

    public static function rules($id = null)
    {
        $unique = empty($id) ? 'unique:category' : 'unique:category,category,' . $id . ',id';

        return [
            'category' => 'required|' . $unique,
            'color' => 'required',
            'text_color' => 'required',
        ];
    }

    public function getCreatedAtAttribute($value)
    {
        $carbon = Carbon::parse($value);

        return Date::instance($carbon);
    }

    public function getUpdatedAtAttribute($value)
    {
        $carbon = Carbon::parse($value);

        return Date::instance($carbon);
    }
}
