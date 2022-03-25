<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['name', 'permissions', 'store_id'];
    protected $table = 'roles';

    /*public function roleusers() {
        return $this->hasMany(Role::class);
    }*/
    public function user()
    {
        return $this->belongsToMany(User::class);
    }
}
