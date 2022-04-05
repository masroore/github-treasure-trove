<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogLiquidation extends Model
{
    protected $table = 'log_liquidations';

    protected $fillable = [
        'idliquidation', 'comentario', 'accion',
    ];

    /**
     * Permite la informacion de la liquidacion asociada.
     */
    public function getLiquidation()
    {
        return $this->belongsTo('App\Models\Liquidaction', 'idliquidation', 'id');
    }
}
