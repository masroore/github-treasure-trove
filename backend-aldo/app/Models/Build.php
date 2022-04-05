<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Build extends Model
{
    use Auditable;
    use HasFactory;
    use SoftDeletes;

    public const STATUS_RADIO = [
        'Aktif' => 'Active',
        'Non-aktif' => 'Non-Active',
        'Perlu Perbaikan' => 'Need Improvement',
    ];

    public const YEAR_SELECT = [
        '2016' => '2016',
        '2017' => '2017',
        '2018' => '2018',
        '2019' => '2019',
        '2020' => '2020',
        '2021' => '2021',
        '2022' => '2022',
        '2023' => '2023',
        '2024' => '2024',
    ];

    public const FUNDED_SELECT = [
        'APBD' => 'APBD',
        'DAK Fisik' => 'DAK Fisik',
        'APBN' => 'APBN',
        'APBD Provinsi' => 'APBD Provinsi',
        'CSR /Swasta' => 'CSR / Swasta',
        'Swadaya Masyarakat' => 'Swadaya Masyarakat',
    ];

    public $table = 'builds';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'categories_id',
        'address',
        'kecamatans_id',
        'kelurahans_id',
        'lat',
        'lng',
        'year',
        'status',
        'funded',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function categories()
    {
        return $this->belongsTo(Category::class, 'categories_id');
    }

    public function kecamatans()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatans_id');
    }

    public function kelurahans()
    {
        return $this->belongsTo(Kelurahan::class, 'kelurahans_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
