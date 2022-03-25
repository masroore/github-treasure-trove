<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    use HasFactory;

    protected $fillable = [
    'title',
    'original_price',
    'deal_price',
    'quantity',
    'description',
    'start_date',
    'end_date',
    'never_expires',
    'start_time',
    'end_time',
    'every_time',
    'status',
    'labels',
    'specification',
    'tags',
    'store_id',
];

    protected $casts = [
        'specification' => 'array',
        'tags' => 'array',
        'lables' => 'array',
    ];

    public function groups()
    {
        return $this->hasMany(DealGroups::class);
    }
}
