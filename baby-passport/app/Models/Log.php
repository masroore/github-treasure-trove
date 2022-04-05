<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Log.
 *
 * @version September 11, 2018, 5:26 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection user
 * @property int user_id
 * @property string uuid
 * @property string code
 * @property string description
 * @property string type
 * @property date created_at
 */
class Log extends Model
{
    protected $table = 'log';

    /**
     * The attributes that can be fillable.
     *
     * @var array
     */
    public $fillable = [
        'uuid',
        'user_id',
        'code',
        'description',
        'type',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'uuid' => 'string',
        'code' => 'string',
        'user_id' => 'integer',
        'description' => 'string',
        'type' => 'string',
    ];
}
