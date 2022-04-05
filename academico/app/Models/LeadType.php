<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\LeadType.
 *
 * @property int $id
 * @property array $name
 * @property null|array $description
 * @property null|string $icon
 * @property null|\Illuminate\Support\Carbon $created_at
 * @property null|\Illuminate\Support\Carbon $updated_at
 * @property mixed $translated_name
 * @property array $translations
 * @property \App\Models\Student[]|\Illuminate\Database\Eloquent\Collection $students
 * @property null|int $students_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|LeadType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadType query()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadType whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LeadType extends Model
{
    use CrudTrait;
    use HasTranslations;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['name', 'description'];

    public $translatable = ['name', 'description'];

    // protected $hidden = [];
    // protected $dates = [];
    protected $appends = ['translated_name'];

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

    public function students()
    {
        return $this->hasMany(Student::class);
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

    public function getTranslatedNameAttribute()
    {
        return $this->getTranslation('name', app()->getLocale());
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
