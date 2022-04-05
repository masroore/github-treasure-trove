<?php

namespace App\Models;

use Fomvasss\Filterable\Filterable;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Handbook extends Model
{
    use Filterable;
    use Sortable;

    protected $guarded = ['id'];

    protected $searchable = [
        'mark', 'model', 'year',
    ];

    protected $sortable = [
        'id',
        'created_at',
    ];

    protected $filterable = [
        'name' => 'like',
        'status' => 'equal',
    ];

    public const STATUS_PUBLISHED = 'published';
    public const STATUS_MODERATE = 'moderate';

    public static function statusList(?string $columnKey = null, ?string $indexKey = null): array
    {
        $records = [
            [
                'key' => self::STATUS_PUBLISHED,
                'name' => trans('system.car.status.published'),
            ],
            [
                'key' => self::STATUS_MODERATE,
                'name' => trans('system.car.status.published'),
            ],
        ];

        return self::staticListBuild($records, $columnKey, $indexKey);
    }

    public function getStatusStr(): string
    {
        return self::statusList('name', 'key')[$this->status] ?? '';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class, 'car_id', 'id');
    }
}
