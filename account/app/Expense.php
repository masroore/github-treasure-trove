<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'category_id', 'description', 'amount', 'date', 'project_id', 'user_id', 'attachment', 'created_by',
    ];

    public function category()
    {
        return $this->hasOne('App\ExpensesCategory', 'id', 'category_id');
    }

    public function projects()
    {
        return $this->hasOne('App\Projects', 'id', 'project');
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
