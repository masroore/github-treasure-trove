<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Region extends Model
{
    use SoftDeletes;

    protected $fillable = [];

    public function upsos()
    {
        return $this->hasMany(Upso::class);
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function count_upsos($upso_type_id)
    {
        if ($upso_type_id) {
            return $this->upsos()->where('upso_type_id', $upso_type_id)->count();
        }

        return $this->upsos->count();
    }

    public function managers()
    {
        return $this->hasManyThrough(Manager::class, Upso::class);
    }

    public function count_managers($upso_type_id)
    {

        // $upso_type_id = 1;
        // $upsos = Upso::where('upso_type_id', $upso_type_id)
        // ->
        if ($upso_type_id) {
            return $this->managers()->where('upso_type_id', $upso_type_id)->count();
            // return $this->upsos->managers()->where('upso_type_id', $upso_type_id)->count();
        }

        return $this->managers()->count();
        // return $this->upsos->managers()->count();
    }
}
