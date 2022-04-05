<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'cart';

    protected $fillable = [
        'iduser',
        'categories_id',
        'package_id',
        'cantidad',
        'monto',
        'total',
    ];

    /**
     * Permite obtener el paquete.
     */
    public function getPackage()
    {
        return $this->belongsTo('App\Models\Packages', 'package_id', 'id', 'name', 'img');
    }

    /**
     * Permite obtener la categoria.
     */
    public function getCategories()
    {
        return $this->belongsTo('App\Models\Categories', 'categories_id', 'id', 'categories_name');
    }
}
