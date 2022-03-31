<?php

namespace App\Models\Settings;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class SliderGroup extends Model
{
    /**
     * @var string
     */
    protected $table = 'slider_groups';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sliders()
    {
        return $this->hasMany(Slider::class, 'group_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sliders_count()
    {
        return $this->hasMany(Slider::class, 'group_id')->count();
    }

    /**
     * @param $request
     *
     * @throws \Exception
     *
     * @return bool
     */
    public static function store($request)
    {
        return self::insert([
            'name'        => $request->name,
            'product_id'  => $request->product_id,
            'category_id' => $request->category_id,
            'page_id'     => $request->page_id,
            'date_start'  => new Carbon($request->date_start),
            'date_end'    => new Carbon($request->date_end),
            'status'      => (isset($request->status) && 'on' == $request->status) ? 1 : 0,
            'created_at'  => Carbon::now(),
            'updated_at'  => Carbon::now(),
        ]);
    }

    /**
     * @param $request
     * @param $id
     *
     * @throws \Exception
     *
     * @return bool
     */
    public static function edit($request, $id)
    {
        return self::where('id', $id)->update([
            'name'        => $request->name,
            'product_id'  => $request->product_id,
            'category_id' => $request->category_id,
            'page_id'     => $request->page_id,
            'date_start'  => new Carbon($request->date_start),
            'date_end'    => new Carbon($request->date_end),
            'status'      => (isset($request->status) && 'on' == $request->status) ? 1 : 0,
            'updated_at'  => Carbon::now(),
        ]);
    }

    /**
     * @param $id
     */
    public static function destroyAll($id)
    {
        self::where('id', $id)->delete();

        return Slider::where('group_id', $id)->delete();
    }
}
