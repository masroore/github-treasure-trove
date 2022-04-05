<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Milestone extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'proposal_id',
        'user_id',
        'milestone_amount',
        'milestone_receive_amount',
        'milestone_service_fee',
        'detail',
        'due_date',
        'status',
    ];
}
