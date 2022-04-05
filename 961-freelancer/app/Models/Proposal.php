<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'user_id',
        'budget',
        'budget_receive',
        'service_fee',
        'cover_letter',
        'proposal_type',
        'duration',
        'proposed_hours',
        'attachments',
        'status',
    ];

    public static function isBidAvailable($user_id, $job_id)
    {
        return self::where('user_id', $user_id)->where('job_id', $job_id)->first();
    }

    public static function getProposalCount($job_id)
    {
        return self::where('job_id', $job_id)->count();
    }

    public static function freelancer($user_id)
    {
        return User::where('id', $user_id)->first();
    }

    public static function milestones($id)
    {
        return Milestone::where('proposal_id', $id)->get();
    }

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id', 'job_id');
    }

    public function rating()
    {
        return $this->hasMany(Rating::class, 'rating_to', 'user_id');
    }

    public function freelancerRating()
    {
        return $this->belongsTo(Rating::class, 'job_id', 'job_id');
    }

    public static function freelancerCompletedCount($user_id)
    {
        return self::where('user_id', $user_id)->where('status', 5)->count();
    }

    public static function freelancerCancelledCount($user_id)
    {
        return self::where('user_id', $user_id)->where('status', 3)->orWhere('status', 4)->count();
    }

    public static function freelancerOngoingCount($user_id)
    {
        return self::where('user_id', $user_id)->where('status', 2)->count();
    }

    public static function selectedProposal($job_id)
    {
        return self::where('job_id', $job_id)->where('status', 2)->first();
    }
}
