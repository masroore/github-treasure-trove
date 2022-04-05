<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;

class Blog extends Model
{
    protected $table = 'blog';

    protected $fillable = [
        'title',
        'poster_intro',
        'intro',
        'poster_image',
        'detail_image',
        'date_to_publish',
        'date_to_expire',
        'status',
    ];

    protected $casts = [
        'title' => 'string',
        'poster_intro' => 'string',
        'intro' => 'string',
        'poster_image' => 'string',
        'detail_image' => 'string',
        'status' => 'integer',
    ];

    protected $dates = [
        'date_to_publish',
        'date_to_expire',
    ];

    public function getDateToPublishAttribute($value)
    {
        $carbon = Carbon::parse($value);

        return Date::instance($carbon);
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

    public static function rules($id, $request)
    {
        $uniqueTitle = empty($id) ? 'unique:blog' : 'unique:blog,title,' . $id . ',id';

        $rules = [
            'blog.title' => 'required|' . $uniqueTitle,
            'blog.poster_intro' => 'required',
            'blog.intro' => 'required',
            'blog.poster_image' => $id == null ? 'required |' : '' . 'mimes:jpeg,bmp,png,gif,jpg',
            'blog.detail_image' => $id == null ? 'required |' : '' . 'mimes:jpeg,bmp,png,gif,jpg',
            'blog.date_to_publish' => 'required|date_format:Y-m-d',
            'blog.category_id' => 'required|integer',
            'blog_tag' => 'required',
        ];

        if (isset($request['blog_tag'])) {
            foreach ($request['blog_tag'] as $index => $tag) {
                $rules['blog_tag.' . $index . '.integer'] = 'integer';
            }
        }

        return $rules;
    }

    public static function recentPosts($limit)
    {
        $blogs = self::where('status', 1)
            ->orderBy('id', 'desc')
            ->limit($limit)
            ->get();

        return $blogs;
    }

    public function topics()
    {
        return $this->hasMany(\App\Models\BlogTopic::class);
    }

    public function relatedCategories()
    {
        return $this->hasMany(\App\Models\BlogCategory::class);
    }

    public function relatedTags()
    {
        return $this->hasMany(\App\Models\BlogTag::class);
    }

    public function tags()
    {
        return $this->hasManyThrough(
            'App\Models\Tag',
            'App\Models\BlogTag',
            'blog_id', //Blog tag blog id
            'id', //tag id
            '',
            'tag_id' //blog tag tag-id
        );
    }

    public function categories()
    {
        return $this->hasManyThrough(
            \App\Models\Category::class,
            \App\Models\BlogCategory::class,
            'blog_id',
            'id',
            '',
            'category_id'
        );
    }
}
