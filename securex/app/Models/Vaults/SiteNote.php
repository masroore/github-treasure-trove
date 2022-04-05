<?php

namespace App\Models\Vaults;

use App\Http\Traits\EncryptAttributes;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class SiteNote extends Model
{
    use EncryptAttributes;

    /**
     * Table associated with this model.
     */
    protected $table = 'notes';

    /**
     * The attributes that should be encrypted and decrypted on the fly.
     *
     * @var array
     */
    protected $encrypted = ['content'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content', 'user_id', 'body',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'site_id',
    ];

    /**
     * Relation between a Note and a User.
     * A note belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation between a Note and a Site.
     * A note belongs to a site.
     */
    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id');
    }
}
