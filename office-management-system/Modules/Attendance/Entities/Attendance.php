<?php

namespace Modules\Attendance\Entities;

use App\User;
use Auth;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendances';

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTableColumns()
    {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }

    public static function boot(): void
    {
        parent::boot();
        static::saving(function ($brand): void {
            $brand->created_by = Auth::user()->id ?? null;
        });

        static::updating(function ($brand): void {
            $brand->updated_by = Auth::user()->id ?? null;
        });
    }
}
