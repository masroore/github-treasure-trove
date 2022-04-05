<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavingFee extends Model
{
    protected $table = 'savings_fees';

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
