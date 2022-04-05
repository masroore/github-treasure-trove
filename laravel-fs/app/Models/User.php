<?php

namespace App\Models;

use App\Traits\EncryptationId;
use DB;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use EncryptationId;

    protected $table = 'users';

    protected $fillable = ['id', 'name_user', 'surname_user', 'username', 'password', 'phone', 'email', 'special_permission', 'sensitive_info', 'change_password', 'locked', 'time_inactivity', 'avatar', 'type_document_id', 'telephone_operator_id', 'profile_id', 'theme_id', 'user_id', 'register_date', 'ip'];

    protected $connection = 'mysql';

    public $timestamps = false;

    protected $appends = ['storage', 'storage_id', 'profile', 'crypt_id', 'suspended'];

    public function getMenu()
    {
        $Menu = Menu::orderBy('order')->get()->toArray();
        foreach ($Menu as $key => $value) {
            foreach ($value['get_process'] as $key2 => $value2) {
                if (!in_array($this->profile_id, $value2['profile_array'])) {
                    unset($Menu[$key]['get_process'][$key2], $Menu[$key]['process'][$key2]);

                }
            }
            if (count($Menu[$key]['get_process']) == 0) {
                unset($Menu[$key]);
            }
        }

        return $Menu;
    }

    public function getProfile()
    {
        return $this->belongsTo(Profile::class, 'profile_id');
    }

    public function getProfileAttribute()
    {
        return $this->getProfile;
    }

    public function isSuspended()
    {
        $instance = $this->getSuspensions();
        $list = $instance->getQuery()->whereBetween(DB::raw("'" . date('Y-m-d H:i:s') . "'"), [DB::raw('start_date'), DB::raw('end_date')])->get();

        return count($list) > 0 ? true : false;
    }

    public function getSuspendedAttribute()
    {
        return $this->isSuspended();
    }

    public function getSuspensions()
    {
        return $this->hasMany(SuspendedUser::class, 'user_suspended_id');
    }

    public function getAccessHistory()
    {
        return $this->hasMany(AccessHistory::class, 'user_id')->orderBy('id', 'desc');
    }

    public function getLastDateAccess()
    {
        if ($this->getAccessHistory->count() > 0) {
            return $this->getAccessHistory->first()->date_out == null ? date('Y-m-d H:i:s') : $this->getAccessHistory->first()->date_out;
        }

        return date('Y-m-d H:i:s');
    }

    public function getStorages()
    {
        return $this->belongsToMany(Storage::class, 'user_storages', 'user_id', 'storage_id');
    }

    public function getPasswordHistory()
    {
        return $this->hasMany(PasswordHistory::class, 'user_id')->orderBy('id', 'desc');
    }

    public function getLastDatePassword()
    {
        if ($this->getPasswordHistory->count() > 0) {
            return $this->getPasswordHistory->first()->end_date == null ? date('Y-m-d H:i:s') : $this->getPasswordHistory->first()->end_date;
        }

        return date('Y-m-d H:i:s');
    }

    public function getStorageAttribute()
    {
        $Storages = $this->getStorages;
        if (count($Storages) > 0) {
            return $Storages[0]->toArray();
        }

        return [];
    }

    public function getStorageIdAttribute()
    {
        $Storages = $this->getStorages;
        if (count($Storages) > 0) {
            return $Storages[0]->id;
        }

        return 0;
    }

    public function getNameStorageAttribute()
    {
        $Storages = $this->getStorages;
        if (count($Storages) > 0) {
            return $Storages[0]->name_storage;
        }

        return 0;
    }
}
