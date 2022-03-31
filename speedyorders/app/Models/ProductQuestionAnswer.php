<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductQuestionAnswer extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_question_answers';

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
    protected $fillable = ['product_question_id', 'answer', 'status'];

    public function productQuestion()
    {
        return $this->belongsTo('App\Models\ProductQuestion');
    }
}
