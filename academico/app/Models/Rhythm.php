<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * This class could perhaps be renamed to Category instead.
 *
 * @property int $id
 * @property string $name
 * @property null|int $default_volume
 * @property null|string $product_code
 * @property null|\Illuminate\Support\Carbon $deleted_at
 * @property null|int $lms_id
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Rhythm newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rhythm newQuery()
 * @method static \Illuminate\Database\Query\Builder|Rhythm onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Rhythm query()
 * @method static \Illuminate\Database\Eloquent\Builder|Rhythm whereDefaultVolume($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rhythm whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rhythm whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rhythm whereLmsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rhythm whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rhythm whereProductCode($value)
 * @method static \Illuminate\Database\Query\Builder|Rhythm withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Rhythm withoutTrashed()
 * @mixin \Eloquent
 */
class Rhythm extends Model
{
    use CrudTrait;
    use SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    // protected $primaryKey = 'id';
    public $timestamps = false;

    protected $guarded = ['id'];
    //protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
