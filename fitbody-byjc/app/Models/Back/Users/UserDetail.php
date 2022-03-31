<?php

namespace App\Models\Back\Users;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    /**
     * @var string
     */
    protected $table = 'user_details';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @param $products
     * @param $order_id
     *
     * @return bool
     */
    public static function storeData($request, $user_id)
    {
        return self::insertGetId([
            'user_id' => $user_id,
            'fname' => $request->user_fname ?? $request->user_name,
            'lname' => $request->user_lname,
            'address' => $request->user_address,
            'zip' => $request->user_zip,
            'city' => $request->user_city,
            'phone' => $request->user_phone,
            'bio' => $request->user_description,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }

    /**
     * @param $products
     * @param $order_id
     *
     * @return bool
     */
    public static function updateData($request, $user_id)
    {
        return self::where('user_id', $user_id)->update([
            'fname' => $request->user_fname ?? $request->user_name,
            'lname' => $request->user_lname,
            'address' => $request->user_address,
            'zip' => $request->user_zip,
            'city' => $request->user_city,
            'phone' => $request->user_phone,
            'bio' => $request->user_description,
            'updated_at' => Carbon::now(),
        ]);
    }

    /**
     * @param $products
     * @param $order_id
     *
     * @return bool
     */
    public static function updateCustomerData($request, $user_id)
    {
        return self::where('user_id', $user_id)->update([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'address' => $request->address,
            'zip' => $request->zip,
            'city' => $request->city,
            'phone' => $request->phone ?? '000',
            'bio' => $request->message_content,
            'updated_at' => Carbon::now(),
        ]);
    }
}
