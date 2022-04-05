<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\AttendanceType.
 *
 * @property int $id
 * @property array $name
 * @property null|string $class
 * @property null|string $icon
 * @property mixed $translated_name
 * @property array $translations
 *
 * @method static \Illuminate\Database\Eloquent\Builder|AttendanceType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AttendanceType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AttendanceType query()
 * @method static \Illuminate\Database\Eloquent\Builder|AttendanceType whereClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttendanceType whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttendanceType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttendanceType whereName($value)
 * @mixin \Eloquent
 */
class AttendanceType extends Model
{
    use HasTranslations;

    public $translatable = ['name'];

    public $timestamps = false;

    protected $appends = ['translated_name'];

    public function getTranslatedNameAttribute()
    {
        return $this->getTranslation('name', app()->getLocale());
    }
}
