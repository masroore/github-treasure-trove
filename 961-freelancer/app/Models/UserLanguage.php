<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLanguage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'language_id',
        'language_rate',
    ];

    public function languageData()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }

    public function freelancer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function freelancerRating()
    {
        return $this->hasMany(Rating::class, 'rating_to', 'user_id');
    }
}
