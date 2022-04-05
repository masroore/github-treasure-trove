<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Socialite.
 */
class Socialite extends Model
{
    protected $guarded = ['id'];

    protected $hidden = [
        'access_token', 'refresh_token',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return array
     */
//    public static function getLoginUrls(): array
//    {
//        $res = [];
//        foreach (config('services.socialite_providers', []) as $item) {
//            $res[$item] = route('socialite.oauth', $item);
//        }
//
//        return $res;
//    }
}
