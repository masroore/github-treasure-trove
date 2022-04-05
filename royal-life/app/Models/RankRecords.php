<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RankRecords extends Model
{
    use HasFactory;

    protected $table = 'rank_records';

    protected $fillable = [
        'iduser', 'rank_actual_id', 'rank_previou_id',
        'fecha_inicio', 'fecha_fin',
    ];
}
