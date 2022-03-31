<?php

namespace App\Models\Back\Settings;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Profile extends Model
{
    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @param $id
     *
     * @return \Illuminate\Database\Query\Builder|Model|object|null
     */
    public static function settings($id)
    {
        return DB::table('app_settings')->where('user_id', $id)->first();
    }

    public static function updateSidebarInverseToggle($id)
    {
        return DB::table('app_settings')->where('user_id', $id)->update([
            'sidebar_inverse' => DB::raw('NOT sidebar_inverse'),
        ]);
    }
}
