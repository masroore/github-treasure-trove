<?php
/**
 * Created by PhpStorm.
 * User: fomvasss
 * Date: 14.01.19
 * Time: 23:02.
 */

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasSafe
{
    protected static function bootHasSafe(): void
    {
        //static::updating(function (Model $model) {
        //    $model->checkIsSafe() ? abort(403) : null;
        //});
        static::deleting(function (Model $model): void {
            if (!app()->runningInConsole()) {
                $model->checkIsSafe() ? abort(403) : null;
            }
        });
    }

    public function checkIsSafe(): bool
    {
        return (bool) $this->safe;
    }
}
