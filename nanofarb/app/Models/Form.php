<?php

namespace App\Models;

use App\Models\Traits\HasMedia\HasMedia;
use App\Models\Traits\HasMedia\HasMediaTrait;
use Fomvasss\Taxonomy\Models\Traits\HasTaxonomies;
use Illuminate\Database\Eloquent\Model;

class Form extends Model implements HasMedia
{
    use HasMediaTrait;
    use HasTaxonomies;

    /** @var int */
    const STATUS_NEW = 1;

    /** @var int */
    const STATUS_PROCESSED_ACCEPT = 2;

    const STATUS_PROCESSED_REJECTED = 3;

    /** @var array */
    public static $formStatuses = [
        self::STATUS_NEW => 'Новый запрос',
        self::STATUS_PROCESSED_ACCEPT => 'Обработано, одобрено',
        self::STATUS_PROCESSED_REJECTED => 'Обработано, отклонено',
    ];

    /** @var array */
    protected $guarded = ['id'];

    /** @var array */
    protected $casts = [
        'data' => 'array',
    ];

    /** @var array */
    protected $mediaFieldsSingle = ['image', 'file'];

    /** @var array */
    protected $mediaFieldsMultiple = ['images', 'files'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function getTypeTitle()
    {
        return config("web-forms.{$this->type}.title", '');
    }

    public function scopeForFront($query, string $type)
    {
        return $query->select('id', 'data', 'created_at')
            ->where('type', $type)
            ->where('status', self::STATUS_PROCESSED_ACCEPT)
            ->orderBy('created_at', 'desc');
    }
}
