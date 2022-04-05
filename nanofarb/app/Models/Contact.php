<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    const TYPE_DELIVERY = 1;

    const TYPE_POST_OFFICE = 2;

    const TYPE_CALL_COURIER = 3;

    protected $guarded = ['id'];

    protected $casts = [
        'datetime' => 'date',
    ];

    public function getFullAttribute()
    {
        $items = [
            $this->name,
            $this->phone,
            $this->email,
            $this->region,
            $this->city,
            $this->address,
            $this->zip_code,
        ];

        return implode(', ', array_filter($items, function ($item) {
            if (!empty($item)) {
                return $item;
            }
        }));
    }
}
