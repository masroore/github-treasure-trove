<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pages';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['parent_id', 'slug', 'title', 'content', 'main_image', 'main_video', 'seo', 'seo_description', 'sort_order', 'status'];

    public function page()
    {
        return $this->belongsTo('App\Models\Page', 'parent_id');
    }
}
