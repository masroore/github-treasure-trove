<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use SoftDeletes;

    public const STATE_SELECT = [
        'Alabama' => 'Alabama',
    ];

    public const CITY_SELECT = [
        'Stratford' => 'Stratford',
    ];

    public $table = 'locations';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'location_code',
        'location_name',
        'street_address',
        'city',
        'state',
        'country',
        'zip_code',
        'active',
        'latitude',
        'longitude',
        'company_id',
        'square_foot',
        'annual_budget',
        'call_in_numbers',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
