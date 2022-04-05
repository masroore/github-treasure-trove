<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CierreComision extends Model
{
    protected $table = 'cierre_comisions';

    protected $fillable = [
        'iduser', 'group_id', 'package_id', 's_inicial',
        's_ingreso', 's_final', 'cierre',
        'comentario',
    ];

    /**
     * Permite obtener al usuario de una Compra.
     */
    public function getGroupAccount()
    {
        return $this->belongsTo('App\Models\Groups', 'group_id');
    }

    /**
     * Permite obtener al usuario de una Compra.
     */
    public function getPackageAccount()
    {
        return $this->belongsTo('App\Models\Packages', 'package_id');
    }
}
