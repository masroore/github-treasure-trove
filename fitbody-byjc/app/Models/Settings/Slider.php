<?php

namespace App\Models\Settings;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    /**
     * @var string
     */
    protected $table = 'sliders';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @param $request
     *
     * @throws \Exception
     *
     * @return bool
     */
    public static function store($request, $group)
    {
        return self::insert([
            'group_id'       => $group,
            'image'          => $request['image'],
            'message'        => $request['message_title'],
            'title'          => $request['title'],
            'subtitle'       => $request['subtitle'],
            'button'         => $request['button'],
            'url'            => $request['url'],
            'text_color'     => $request['text_color'],
            'text_placement' => $request['text_placement'],
            'sort_order'     => 0,
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);
    }
}
