<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealGroups extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'deal_id',
        'status',

    ];

    public function groupDetails()
    {
        return $this->hasMany(DealGroupDetails::class, 'deal_group_id', 'id');
    }
}
