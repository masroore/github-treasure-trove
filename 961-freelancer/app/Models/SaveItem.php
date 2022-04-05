<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaveItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'freelancer_id',
        'job_id',
        'save_type',
        'status',
    ];

    public function userData()
    {
        return $this->belongsTo(User::class, 'freelancer_id', 'id');
    }

    public function jobData()
    {
        return $this->belongsTo(Job::class, 'job_id', 'id');
    }

    public static function jobSaved($user_id, $job_id)
    {
        return self::where('user_id', $user_id)->where('job_id', $job_id)->where('status', 1)->count();
    }
}
