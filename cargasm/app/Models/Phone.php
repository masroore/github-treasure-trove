<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $phone
 * @property string $model_type
 * @property int $model_id
 * @property Carbon $created_at
 * @property Carbon updated_at
 */
class Phone extends Model
{
    protected $guarded = ['id'];

    public function model()
    {
        return $this->morphTo();
    }
}
