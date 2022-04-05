<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kelurahan extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'kelurahans';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'kecamatans_id',
        'geojson',
        'slug',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function kecamatans()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatans_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
