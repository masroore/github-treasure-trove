<?php

namespace App\Models\Vaults;

use App\Http\Traits\EncryptAttributes;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    use EncryptAttributes;
    use Uuid;

    /**
     * The attributes that should be encrypted and decrypted on the fly.
     *
     * @var array
     */
    protected $encrypted = ['password'];

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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'vault_id', 'password', 'icon',
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
     * Relation between a Folder and a Vault.
     * A folder belongs to a Vault.
     */
    public function vault()
    {
        return $this->belongsTo(Vault::class, 'vault_id');
    }

    /**
     * Relation between a Folder and a Site.
     * A folder can have many sites in it.
     */
    public function sites()
    {
        return $this->belongsToMany(Site::class)->orderBy('is_fav', 'DESC');
    }
}
