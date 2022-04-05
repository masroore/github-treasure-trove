<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $fillable = ['departure_city_id', 'arrival_city_id', 'distance', 'user_id'];

    public function departureCity()
    {
        return $this->belongsTo(City::class, 'departure_city_id', 'id');
    }

    public function arrivalCity()
    {
        return $this->belongsTo(City::class, 'arrival_city_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
