<?php

namespace App\Models\Vaults;

use App\Http\Traits\EncryptAttributes;
use App\Models\Users\User;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Model;

class Vault extends Model
{
    use EncryptAttributes;
    use Uuid;

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that should be encrypted and decrypted on the fly.
     *
     * @var array
     */
    protected $encrypted = ['name'];

    /**
     * Always return the modal instance with the count of sites & folders in it.
     */
    protected $withCount = ['sites', 'folders'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'user_id', 'description', 'color', 'icon', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Relation between a vault and a user.
     * A vault belongs to a particular user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation between a vault and a site.
     * A vault can have many sites.
     */
    public function sites()
    {
        return $this->hasMany(Site::class)->orderBy('is_fav', 'DESC');
    }

    public function checkPass($vault)
    {
        if ($vault->password) {
            if (session()->has($vault->id . '-pass')) {
                return true;
            }
        }

        return false;

        return true;
    }

    /**
     * Relation between a Vault and a Folder.
     * A Vault can have many Folders in it.
     */
    public function folders()
    {
        return $this->hasMany(Folder::class);
    }

    /**
     * Returns total count of notes.
     */
    public function total_notes()
    {
        $count = 0;

        foreach ($this->sites as $site) {
            $count = $count + $site->notes->count();
        }

        return $count;
    }
}
