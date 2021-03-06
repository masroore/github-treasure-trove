<?php

/**
 * Target name eloquent model.
 *
 * PHP Version 7
 *
 * @author   Wim De Meester <deepskywim@gmail.com>
 * @license  GPL3 <https://opensource.org/licenses/GPL-3.0>
 *
 * @see     http://www.deepskylog.org
 */

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;

/**
 * Target name eloquent model.
 *
 * @author   Wim De Meester <deepskywim@gmail.com>
 * @license  GPL3 <https://opensource.org/licenses/GPL-3.0>
 *
 * @see     http://www.deepskylog.org
 */
class TargetName extends Model
{
    use Sluggable;

    protected $fillable = ['objectname', 'catalog', 'catindex', 'altname'];

    protected $primaryKey = 'altname';

    public $incrementing = false;

    /**
     * TargetNamess have exactly one Target.
     *
     * @return HasOne The eloquent relationship
     */
    public function target(): HasOne
    {
        return $this->hasOne('App\Models\Target', 'id', 'target_id');
    }

    /**
     * Get catalogs from the TargetName.
     *
     * @return Collection The list with the different catalogs
     */
    public static function getCatalogs(): Collection
    {
        // First get the deepsky catalogs
        $catalogs = self::where('catalog', '!=', '')
            ->select('catalog')->distinct()->get()->pluck('catalog');

        // We add the comets, planets, Moon, Moon craters, ..., Sun.
        $catalogs->push(_i('Planets'));
        $catalogs->push(_i('Planetary Moons'));
        $catalogs->push(_i('Moon Craters'));
        $catalogs->push(_i('Moon Mountains'));
        $catalogs->push(_i('Moon Other Feature'));
        $catalogs->push(_i('Moon Sea'));
        $catalogs->push(_i('Moon Valley'));
        $catalogs->push(_i('Sun'));
        $catalogs->push(_i('Comets'));
        $catalogs->push(_i('Asteroids'));
        $catalogs->push(_i('Dwarf Planets'));

        return $catalogs->sort();
    }

    /**
     * Get catalogs from the TargetName to use in the drop down menu.
     *
     * @return string The list with the different catalogs
     */
    public static function getCatalogsChoices(): string
    {
        // First get the deepsky catalogs
        $catalogs = self::where('catalog', '!=', '')
            ->select('catalog')->distinct()->get()->pluck('catalog');

        $toReturn = '<option value=""></option>';
        $toReturn .= '<option value="M">M</option>';
        $toReturn .= '<option value="NGC">NGC</option>';
        $toReturn .= '<option value="Caldwell">Caldwell</option>';
        $toReturn .= '<option value="H400">H400</option>';
        $toReturn .= '<option value="H400-II">H400-II</option>';
        $toReturn .= '<option value="IC">IC</option>';

        foreach ($catalogs as $catalog) {
            if ($catalog != 'M' && $catalog != 'NGC' && $catalog != 'Caldwell' && $catalog != 'H400' && $catalog != 'H400-II' && $catalog != 'IC') {
                $toReturn .= '<option value="' . $catalog . '">' . $catalog . '</option>';
            }
        }

        return $toReturn;
    }

    /**
     * Check if the object has alternative names.
     *
     * @param Target $target the target
     *
     * @return bool True if the object has alternative names
     */
    public static function hasAlternativeNames(Target $target): bool
    {
        if (self::where('target_id', $target->id)->get()->count() > 1) {
            return true;
        }

        return false;
    }

    /**
     * Returns the alternative names of the object.
     *
     * @param Target $target the target
     *
     * @return string The alternative names of the object
     */
    public static function getAlternativeNames(Target $target): string
    {
        $alternativeNames = '';
        foreach (self::where('target_id', $target->id)->get() as $targetname) {
            if ($targetname->altname != $target->target_name) {
                $alternativeNames .= ($alternativeNames ? '/' : '')
                    . $targetname->altname;
            }
        }

        return $alternativeNames;
    }

    /**
     * Return the sluggable configuration array for this model.
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'altname',
            ],
        ];
    }
}
