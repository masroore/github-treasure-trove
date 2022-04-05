<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Room.
 *
 * @property int $id
 * @property string $name
 * @property int $campus_id
 * @property null|int $capacity
 * @property null|\Illuminate\Support\Carbon $deleted_at
 * @property \App\Models\Campus $campus
 * @property \App\Models\Event[]|\Illuminate\Database\Eloquent\Collection $events
 * @property null|int $events_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Room newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Room newQuery()
 * @method static \Illuminate\Database\Query\Builder|Room onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Room query()
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereCampusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereName($value)
 * @method static \Illuminate\Database\Query\Builder|Room withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Room withoutTrashed()
 * @mixin \Eloquent
 */
class Room extends Model
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
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

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
