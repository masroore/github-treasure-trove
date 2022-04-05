<?php

namespace App\Models;

use App\Models\Traits\HasLang;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasLang;

    protected $guarded = ['id'];

    public $timestamps = false;

    const TYPE_PATH = 'path';
    const TYPE_MODEL = 'model';
    const TYPE_DELIMITER = 'delimiter';

    protected $casts = [
        'active' => 'boolean',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::addGlobalScope('weight', function (Builder $builder): void {
            $builder->orderBy('weight', 'asc')
                ->orderBy('id', 'asc');
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function menu()
    {
        return $this->belongsTo(\App\Models\Menu::class);
    }

    public static function getTypesList()
    {
        return [
            self::TYPE_PATH => 'Путь',
            self::TYPE_DELIMITER => 'Разделитель',
            //self::TYPE_MODEL => 'Модель',
        ];
    }

    public static function getTargetsList()
    {
        return ['_blank', '_self', '_parent', '_top'];
    }
}
