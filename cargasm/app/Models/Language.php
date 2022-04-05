<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $abbr
 * @property Carbon $created_at
 * @property Carbon updated_at
 */
class Language extends Model
{
    protected $guarded = ['id'];
}
