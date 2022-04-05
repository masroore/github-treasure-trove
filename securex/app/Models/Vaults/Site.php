<?php

namespace App\Models\Vaults;

use App\Http\Traits\EncryptAttributes;
use App\Models\Users\User;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Site extends Model implements HasMedia
{
    use EncryptAttributes;
    use InteractsWithMedia;
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
    protected $encrypted = ['login_id', 'login_password', 'additional_info'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'user_id', 'category_id', 'link', 'login_id', 'login_password', 'additional_info', 'is_fav',
    ];

    /**
     * Relation between a site and a vault.
     * A Site belongs to a vault.
     */
    public function vault()
    {
        return $this->belongsTo(Vault::class);
    }

    /**
     * Relation between a site and a user.
     * A Site belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation between an site and a folder.
     * A Site can belong to a folder.
     */
    public function folder()
    {
        return $this->belongsToMany(Folder::class);
    }

    /**
     * A site can have multiple custom fields.
     */
    public function custom_fields()
    {
        return $this->hasMany(SiteCustomField::class);
    }

    /**
     * Relation between a Site and notes.
     * A site can have many notes associated with it.
     */
    public function notes()
    {
        return $this->hasMany(SiteNote::class);
    }

    /**
     * Returns url link without protocols.
     */
    public function getLinkWithoutProtocol()
    {
        return preg_replace('#^[^:/.]*[:/]+#i', '', $this->link);
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('favicon')
            ->singleFile()
            ->useDisk('favicons');
    }
}
