<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Allowance extends Model
{
    public function managers()
    {
        return $this->belongsToMany(Manager::class);
    }

    // function count_managers( $upso_type_id){
    //     if( $upso_type_id ){
    //         return $this->managers()->where('upso_type_id', $upso_type_id)->count();
    //     } else {
    //         return $this->managers()->count();
    //     }
    // }

    // public function managersCount()
    // {
    //     return $this->belongsToMany( Manager::class)
    //                 ->selectRaw('count(managers.id) as aggregate');
    // }

    // public function managersCount()
    // {
    //     return $this->belongsToMany( Manager::class )->selectRaw('count(managers.id) as aggregate')->groupBy('pivot_posts_id');
    // }

    // public function getTagsCountAttribute()
    // {
    //     if ( ! array_key_exists('tagsCount', $this->relations)) $this->load('tagsCount');

    //     $related = $this->getRelation('tagsCount')->first();

    //     return ($related) ? $related->aggregate : 0;
    // }
}
