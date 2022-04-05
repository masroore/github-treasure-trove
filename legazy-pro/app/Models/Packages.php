<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Packages extends Model
{
    protected $table = 'packages';

    protected $fillable = [
        'name', 'group_id', 'price', 'description', 'status', 'minimum_deposit', 'expired',
    ];

    /**
     * Permite obtener el grupo al que pertenece.
     */
    public function getGroup()
    {
        return $this->belongsTo('App\Models\Groups', 'group_id', 'id');
    }

    /**
     * Permite obtener todos los paquetes de un grupo.
     */
    public function E()
    {
        return $this->hasMany('App\Models\OrdenPurchases', 'package_id');
    }

    public function img()
    {
        $imagen = '';
        if ($this->price == 50) {
            $imagen = 'Recurso 3 2.svg';
        } elseif ($this->price == 100) {
            $imagen = 'Recurso 3 3.svg';
        } elseif ($this->price == 200) {
            $imagen = 'Recurso 3 4.svg';
        } elseif ($this->price == 300) {
            $imagen = 'Recurso 3 5.svg';
        } elseif ($this->price == 500) {
            $imagen = 'Recurso 3 6.svg';
        } elseif ($this->price == 1000) {
            $imagen = 'Recurso 3 7.svg';
        } elseif ($this->price == 2000) {
            $imagen = 'Recurso 3 8.svg';
        } elseif ($this->price == 3000) {
            $imagen = 'Recurso 3 9.svg';
        } elseif ($this->price == 5000) {
            $imagen = 'Recurso 3 10.svg';
        } elseif ($this->price == 10000) {
            $imagen = 'Recurso 3 11.svg';
        }

        return asset('assets/img/' . $imagen);
    }
}
