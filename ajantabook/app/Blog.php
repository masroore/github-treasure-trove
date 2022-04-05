<?php

namespace App;

use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Blog extends Model implements Viewable
{
    use HasTranslations;
    use InteractsWithViews;

    public $translatable = ['heading', 'user', 'about', 'post', 'des'];

    protected $fillable = [
        'heading', 'image', 'des', 'user', 'status', 'about', 'post', 'slug',
    ];

    public function comments()
    {
        return $this->hasMany('App\BlogComment', 'post_id');
    }
}
