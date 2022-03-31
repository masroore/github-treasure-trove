<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompletedHours extends Model
{
    use HasFactory;
    protected $fillable = [
      'job_id',
      'proposal_id',
      'hourly_amount',
      'completed_hours',
      'weekly_payment',
      'status',
    ];
}
