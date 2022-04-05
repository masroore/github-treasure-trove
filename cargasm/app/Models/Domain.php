<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $url
 * @property Carbon $created_at
 * @property Carbon updated_at
 */
class Domain extends Model
{
    protected $guarded = ['id'];

    public function languages()
    {
        return $this->belongsToMany(Language::class);
    }

    public static function checkValidDomain($domain)
    {
        $domain = self::where('url', $domain)->first();

        return $domain;
    }
}
