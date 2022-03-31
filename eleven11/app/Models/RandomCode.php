<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RandomCode extends Model
{
    use SoftDeletes;

    public $table = 'random_codes';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'code',
        'active',
        'location_code_id',
        'company_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function location_code()
    {
        return $this->belongsTo(Location::class, 'location_code_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
