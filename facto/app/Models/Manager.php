<?php

namespace App\Models;

use App\Casts\AllowanceCast;
use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    // protected $cast = [
    //     'allowances' => AllowanceCast::class,
    // ];

    public function upso()
    {
        return $this->belongsTo(Upso::class);
    }

    public function all_images()
    {
        return $this->morphMany(AllImage::class, 'all_imagable');
    }

    public function allowances()
    {
        return $this->belongsToMany(Allowance::class);
    }
}
