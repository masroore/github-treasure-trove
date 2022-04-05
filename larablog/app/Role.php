<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name',
    ];

    // Define role and user relation
    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    // Define role and permissions relation
    public function permissions()
    {
        return $this->belongsToMany(Permission::class)->withTimestamps();
    }

    // /* attach permission to a role */
    // public function allowedTo($permission)
    // {
    //     return $this->permissions()->save($permission);
    // }
}
