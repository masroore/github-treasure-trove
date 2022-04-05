<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $table = 'wallets';

    protected $fillable = [
        'iduser', 'referred_id', 'orden_purchases_id', 'liquidation_id', 'monto',
        'descripcion', 'status', 'tipo_transaction',
        'liquidado',
    ];

    /**
     * Permite obtener la orden de esta comision.
     */
    public function getWalletComisiones()
    {
        return $this->belongsTo('App\Models\OrdenPurchases', 'orden_purchases_id', 'id');
    }

    /**
     * Permite obtener al usuario de una comision.
     */
    public function getWalletUser()
    {
        return $this->belongsTo('App\Models\User', 'iduser', 'id');
    }

    /**
     * Permite obtener al referido de una comision.
     */
    public function getWalletReferred()
    {
        return $this->belongsTo('App\Models\User', 'referred_id', 'id');
    }

    public function getLiquidation()
    {
        return $this->belongsTo('App\Models\Liquidaction', 'liquidation_id', 'id');
    }
}
