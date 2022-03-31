<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProject extends Model
{
    use HasFactory;
    protected $fillable = [
      'user_id',
      'project_title',
      'project_url',
      'project_img',
      'pdf_files',
      'youtube_link',
      'project_desc',
    ];
}
