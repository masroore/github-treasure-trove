<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserExperience extends Model
{
    use HasFactory;
    protected $fillable = [
      'user_id',
      'company_title',
      'start_date',
      'end_date',
      'present_job',
      'job_title',
      'job_description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
