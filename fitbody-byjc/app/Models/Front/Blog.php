<?php

namespace App\Models\Front;

use App\Models\Back\Marketing\Blog\BlogTag;
use App\Models\Back\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Blog extends Model
{
    /**
     * @var string
     */
    protected $table = 'blogs';

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
     * @return Relation
     */
    public function tags()
    {
        return $this->hasManyThrough(Tag::class, BlogTag::class, 'blog_id', 'id', 'id', 'tag_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    /**
     * @param $query
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', 1);
    }

    /**
     * @param $query
     */
    public function scopePopular($query)
    {
        return $query->orderBy('viewed', 'desc');
    }

    /**
     * @param $query
     * @param $limit
     */
    public function scopeLast($query, $count = 3)
    {
        return $query->orderBy('updated_at', 'desc')->limit($count)->with('tags');
    }
}
