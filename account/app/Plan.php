<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    public static $arrDuration = [
        'unlimited' => 'Unlimited',
        'month' => 'Per Month',
        'year' => 'Per Year',
    ];

    protected $fillable = [
        'name',
        'price',
        'duration',
        'max_users',
        'max_customers',
        'max_venders',
        'description',
        'image',
    ];

    public static function total_plan()
    {
        return self::count();
    }

    public static function most_purchese_plan()
    {
        $free_plan = self::where('price', '<=', 0)->first()->id;

        return User::select(DB::raw('count(*) as total'))->where('type', '=', 'company')->where('plan', '!=', $free_plan)->groupBy('plan')->first();
    }
}
