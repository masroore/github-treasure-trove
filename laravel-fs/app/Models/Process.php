<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    use EncryptationId;

    protected $table = 'processes';

    protected $fillable = ['id', 'name_process', 'description', 'icon', 'route', 'menu_id'];

    protected $connection = 'mysql';

    protected $appends = ['profile', 'profile_array', 'crypt_id'];

    public $timestamps = false;

    public function getProfileArrayAttribute()
    {
        $list_id = [];
        foreach ($this->getProfile as $key => $value) {
            $list_id[] = $value->id;
        }

        return $list_id;
    }

    public function getProfileAttribute()
    {
        return $this->getProfile;
    }

    public function getProfile()
    {
        return $this->belongsToMany(Profile::class, 'profile_processes')
            ->withPivot('profile_id', 'process_id');
    }
}
