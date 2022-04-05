<?php

namespace App;

use App\Models\Storage;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['bank_id', 'list_bank_id', 'theme_name', 'storage_id', 'list_storage_id', 'storage'];

    public function getListBankIdAttribute()
    {
        $list_id = $this->getStorages->toArray();
        $ids_banks = [];

        foreach ($list_id as $value) {
            if (!in_array($value['get_banks']['id'], $ids_banks)) {
                $ids_banks[] = $value['get_banks']['id'];
            }
        }

        return $ids_banks;
    }

    public function getBankIdAttribute()
    {
        $Storages = $this->getStorages;
        if (count($Storages) > 0) {
            return $Storages[0]->toArray()['get_banks']['id'];
        }

        return null;
    }

    public function getThemeNameAttribute()
    {
        return $this->getTheme->class_name;
    }

    public function getTheme()
    {
        return $this->belongsTo(\App\Models\Theme::class, 'theme_id');
    }

    public function getStorages()
    {
        return $this->belongsToMany(Storage::class, 'user_storages', 'user_id', 'storage_id');
    }

    public function getStorageIdAttribute()
    {
        $Storages = $this->getStorages;
        if (count($Storages) > 0) {
            return $Storages[0]->id;
        }

        return null;
    }

    public function getListStorageIdAttribute()
    {
        $list_id = $this->getStorages->toArray();
        $ids_storage = [];
        foreach ($list_id as $value) {
            $ids_storage[] = $value['id'];
        }

        return $ids_storage;
    }

    public function getStorageAttribute()
    {
        $Storages = $this->getStorages;
        if (count($Storages) > 0) {
            return $Storages[0]->toArray();
        }

        return [];
    }
}
