<?php

/**
 * TargetPartOf eloquent model.
 *
 * PHP Version 7
 *
 * @author   Wim De Meester <deepskywim@gmail.com>
 * @license  GPL3 <https://opensource.org/licenses/GPL-3.0>
 *
 * @see     http://www.deepskylog.org
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * TargetPartOf eloquent model.
 *
 * @author   Wim De Meester <deepskywim@gmail.com>
 * @license  GPL3 <https://opensource.org/licenses/GPL-3.0>
 *
 * @see     http://www.deepskylog.org
 */
class TargetPartOf extends Model
{
    protected $table = 'target_partof';

    public $incrementing = false;

    /**
     * Check if the object is part of another object.
     *
     * @param Target $target the target
     *
     * @return bool True if the object is part of another object
     */
    public static function isPartOf(Target $target): bool
    {
        return self::where('target_id', $target->id)->get()->count();
    }

    /**
     * Check if the object contains other objects.
     *
     * @param Target $target the target
     *
     * @return bool True if the object contains other objects
     */
    public static function contains(Target $target): bool
    {
        return self::where('partof_id', $target->id)->get()->count();
    }

    /**
     * Returns the string with the information if the object contains or is
     * part of another object.
     *
     * @param Target $target the target
     *
     * @return string The string with the contains / part of information
     */
    public static function partOfContains(Target $target): string
    {
        $output = '(';

        $contains = '';
        if (self::contains($target)) {
            foreach (self::where('partof_id', $target->id)->get() as $partOfObject) {
                $containsName = \App\Models\Target::where('id', $partOfObject->target_id)
                    ->first()->target_name;
                $slug = \App\Models\Target::where('id', $partOfObject->target_id)
                    ->first()->slug;
                $contains .= ($contains ? '/' : '')
                    . '<a href="/target/' . $slug . '">'
                    . $containsName . '</a>';
            }
        } else {
            $contains .= '-';
        }
        $output .= $contains;

        $output .= ')/';

        $partOf = '';
        if (self::isPartOf($target)) {
            foreach (self::where('target_id', $target->id)->get() as $partOfObject) {
                $partofname = \App\Models\Target::where('id', $partOfObject->partof_id)
                    ->first()->target_name;
                $slug = \App\Models\Target::where('id', $partOfObject->partof_id)
                    ->first()->slug;
                $partOf .= ($partOf ? '/' : '')
                    . '<a href="/target/' . $slug . '">'
                    . $partofname . '</a>';
            }
        } else {
            $partOf .= '-';
        }
        $output .= $partOf;

        return $output;
    }

    /**
     * Returns the string with the information of the moons for this
     * planet.
     *
     * @param Target $target the planet
     *
     * @return string The string with the moons of the planet
     */
    public static function moons(Target $target): string
    {
        $output = '';

        $contains = '';
        if (self::contains($target)) {
            foreach (self::where('partof_id', $target->id)->get() as $partOfObject) {
                $containsName = \App\Models\Target::where('id', $partOfObject->target_id)
                    ->first()->target_name;
                $slug = \App\Models\Target::where('id', $partOfObject->target_id)
                    ->first()->slug;
                $contains .= ($contains ? '/' : '')
                    . '<a href="/target/' . $slug . '">'
                    . $containsName . '</a>';
            }
        } else {
            $contains .= '-';
        }
        $output .= $contains;

        return $output;
    }

    /**
     * Returns the string with the name of the planet if the target is a moon.
     *
     * @param Target $target the target
     *
     * @return string The string with the planet
     */
    public static function planet(Target $target): string
    {
        $partOf = '';
        if (self::isPartOf($target)) {
            foreach (self::where('target_id', $target->id)->get() as $partOfObject) {
                $partofname = \App\Models\Target::where('id', $partOfObject->partof_id)
                    ->first()->target_name;
                $slug = \App\Models\Target::where('id', $partOfObject->partof_id)
                    ->first()->slug;
                $partOf .= ($partOf ? '/' : '')
                    . '<a href="/target/' . $slug . '">'
                    . $partofname . '</a>';
            }
        } else {
            $partOf .= '-';
        }

        return $partOf;
    }
}
