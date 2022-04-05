<?php

namespace App\Models\Shop\External;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use Filterable;

    protected $table = 'external_orders';

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'confirmed_at' => 'datetime',
        'purchases' => 'array',
        'client' => 'array',
        'raw' => 'array',
    ];

    protected $filterable = [
        'number' => 'like',
        'client_data' => 'custom',
        'price' => 'between',
        'status' => 'in',
        'confirmed_at' => 'between_date',
    ];

    public function scopeCustomFilterable($query, $key, $attributes)
    {
        if ($key === 'client_data' && !empty($attributes)) {
            return $query->where(function ($q) use ($attributes): void {
                $q->where('client->fullname', 'LIKE', "%$attributes%")
                    ->orWhere('client->email', 'LIKE', "%$attributes%")
                    ->orWhere('client->phone', 'LIKE', "%$attributes%");
            });
        }
    }

    public static function getStatuses(string $column = 'title', string $key = 'id')
    {
        return \App\ExternalShop\Drivers\ShopDriver::getStatuses($column, $key);
    }

    public function getStatusStr(string $column = 'title')
    {
        return self::getStatuses($column)[$this->status] ?? '-';
    }
}
