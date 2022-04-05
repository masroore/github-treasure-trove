<?php

namespace App\Models\Vaults;

use App\Http\Traits\EncryptAttributes;
use Illuminate\Database\Eloquent\Model;

class SiteCustomField extends Model
{
    use EncryptAttributes;

    /**
     * The attributes that should be encrypted and decrypted on the fly.
     *
     * @var array
     */
    protected $encrypted = ['name', 'value'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'site_id', 'name', 'value',
    ];

    /**
     * A Site custom field belongs to a Site.
     */
    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
