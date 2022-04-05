<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Packages extends Model
{
    protected $table = 'packages';

    protected $fillable = [
        'name',
        'categories_id',
        'categories_name',
        'precio_rebajado',
        'img',
        'price',
        'description',
        'status',
        'expired',
    ];

    /**
     * Permite obtener el grupo al que pertenece.
     */
    public function getCategories()
    {
        return $this->belongsTo('App\Models\Categories', 'categories_id', 'id', 'categories_name');
    }

    /**
     * Permite obtener todos los paquetes de un grupo.
     */
    public function E()
    {
        return $this->hasMany('App\Models\OrdenPurchases', 'package_id', 'name');
    }

    public function getCart()
    {
        return $this->hasMany('App\Models\Cart', 'package_id');
    }

    public function img()
    {
        $imagen = '';
        if ($this->price == 50) {
            $imagen = 'paquete_50.svg';
        } elseif ($this->price == 100) {
            $imagen = 'paquete_100.svg';
        } elseif ($this->price == 200) {
            $imagen = 'paquete_200.svg';
        } elseif ($this->price == 300) {
            $imagen = 'paquete_300.svg';
        } elseif ($this->price == 500) {
            $imagen = 'paquete_500.svg';
        } elseif ($this->price == 1000) {
            $imagen = 'paquete_1000.svg';
        } elseif ($this->price == 2000) {
            $imagen = 'paquete_2000.svg';
        } elseif ($this->price == 3000) {
            $imagen = 'paquete_3000.svg';
        } elseif ($this->price == 5000) {
            $imagen = 'paquete_5000.svg';
        } elseif ($this->price == 10000) {
            $imagen = 'paquete_10000.svg';
        }

        return asset('assets/img/' . $imagen);
    }
}
