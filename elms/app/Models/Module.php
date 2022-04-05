<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function quarter()
    {
        return $this->belongsTo(Quarter::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function resources()
    {
        return $this->hasMany(Resource::class);
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function scopeByDepartment($query, $department)
    {
        return $query->whereHas('section', function (Builder $q) use ($department): void {
            $q->whereHas('teacher', function (Builder $q) use ($department): void {
                $q->where('department_id', $department);
            });
        });
    }
}
