<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenPurchases extends Model
{
    use HasFactory;

    protected $table = 'orden_purchases';

    protected $fillable = [
        'iduser', 'group_id', 'package_id',
        'cantidad', 'total', 'idtransacion',
        'status', 'monto',
    ];

    /**
     * Permite obtener al usuario de una Compra.
     */
    public function getOrdenUser()
    {
        return $this->belongsTo('App\Models\User', 'iduser', 'id');
    }

    /**
     * Permite obtener al usuario de una Compra.
     */
    public function getGroupOrden()
    {
        return $this->belongsTo('App\Models\Groups', 'group_id');
    }

    /**
     * Permite obtener al usuario de una Compra.
     */
    public function getPackageOrden()
    {
        return $this->belongsTo('App\Models\Packages', 'package_id');
    }

    public function getInversionOrden()
    {
        return $this->belongsTo('App\Models\Inversion', 'inversion_id');
    }
}
