<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCertification extends Model
{
    use HasFactory;
    protected $fillable = [
      'user_id',
      'certificate_title',
      'issue_date',
      'expire_date',
      'certificate_desc',
    ];
}
