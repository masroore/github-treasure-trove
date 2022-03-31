<?php

namespace App\Models;

use App\Traits\Auditable;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Device extends Model
{
    use Auditable;
    use HasFactory;
    use SoftDeletes;

    public $table = 'devices';

    public static $searchable = [
        'udid',
    ];

    protected $dates = [
        'date_test',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'udid',
        'token',
        'key',
        'date_test',
        'covid',
        'risk',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function getDateTestAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDateTestAttribute($value)
    {
        $this->attributes['date_test'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
