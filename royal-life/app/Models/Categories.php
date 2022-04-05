<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'categories_name',
        'id',
        'status',
        'description',
        'img',
    ];

    /**
     * Permite obtener todos los paquetes de un grupo.
     */
    public function getPackage()
    {
        return $this->hasMany('App\Models\Packages', 'categories_id');
    }

    /**
     * Permite obtener todos los paquetes de un grupo.
     */
    public function getOrdenPurchase()
    {
        return $this->hasMany('App\Models\OrdenPurchases', 'categories_id');
    }
}
