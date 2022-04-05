<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataOrdenUser extends Model
{
    use HasFactory;

    protected $table = 'orden_user_data';

    protected $fillable = [
        'iduser',
        'name',
        'lastname',
        'country',
        'address',
        'city',
        'state',
        'email',
        'phone',
        'categories_id',
        'package_id',
        'cantidad',
        'total',
        'idtransacion',
        'status',
        'monto',
    ];

    /**
     * Permite obtener al usuario de una Compra.
     */
    public function getOrdenUser()
    {
        return $this->belongsTo('App\Models\User', 'iduser', 'id');
    }

    /**
     * Permite obtener la categoria de una Compra.
     */
    public function getCategoriesOrden()
    {
        return $this->belongsTo('App\Models\Categories', 'categories_id');
    }

    /**
     * Permite obtener el id de una compra.
     */
    public function getPackageOrden()
    {
        return $this->belongsTo('App\Models\Packages', 'package_id');
    }

    /**
     * Permite obtener el id de una inversion.
     */
    public function getInversionOrden()
    {
        return $this->belongsTo('App\Models\Inversion', 'inversion_id');
    }
}
