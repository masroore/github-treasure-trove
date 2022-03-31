<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEducation extends Model
{
    use HasFactory;
    protected $fillable = [
      'user_id',
      'institute',
      'start_date',
      'end_date',
      'continue_study',
      'degree',
      'area_of_study',
      'description',
    ];

    public function userInfo()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
