<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paragraph extends Model
{
    protected $dates = ['created_at', 'published_at'];

    protected $guarded = [];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'paras';

    public function page()
    {
        return $this->belongsToOne(Page::class);
    }

    public function path()
    {
        return "/paragraph/{$this->id}";
    }
}
