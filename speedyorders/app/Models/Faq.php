<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'faqs';

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
    protected $fillable = ['faq_category_id', 'type', 'question', 'answer', 'sort_order', 'status'];

    public function faqCategory()
    {
        return $this->belongsTo('App\Models\FaqCategory');
    }
}
