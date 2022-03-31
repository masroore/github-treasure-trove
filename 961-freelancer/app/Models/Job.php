<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    protected $fillable = [
      'user_id',
      'job_id',
      'job_title',
      'service_level',
      'job_type',
      'hourly_min_price',
      'hourly_max_price',
      'fixed_price',
      'job_duration',
      'is_featured',
      'job_description',
      'job_skills',
      'job_cat',
      'job_location',
      'job_attachement',
      'job_status',
    ];

    public function clientInfo()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function saveJobs()
    {
        return $this->hasMany(SaveItem::class, 'job_id');
    }

    public function proposal()
    {
        return $this->hasMany(Proposal::class, 'job_id', 'job_id');
    }

    public function clientRating()
    {
        return $this->belongsTo(Rating::class, 'job_id', 'job_id');
    }

    public static function client($user_id)
    {
        return User::where('id', $user_id)->first();
    }

    public static function selectProposal($job_id)
    {
        return Proposal::where('job_id', $job_id)->first();
    }

    public static function jobData($job_id)
    {
        return self::where('job_id', $job_id)->first();
    }

    public static function getFreelancerFeedback($user_id)
    {
        return Rating::where('rating_to', $user_id)->count();
    }

    public static function getFeedbackAvg($user_id)
    {
        $ratings = Rating::where('rating_to', $user_id)->get();
        $rating_avg = 0.0;
        $total = 0;
        foreach ($ratings as $rating) {
            $total = $total + $rating->general_rating;
            $rating_avg = $total / \count($ratings);
        }

        return $rating_avg;
    }

    public static function clientCompletedCount($user_id)
    {
        return self::where('user_id', $user_id)->where('job_status', 4)->count();
    }

    public static function clientCancelledCount($user_id)
    {
        return self::where('user_id', $user_id)->where('job_status', 3)->count();
    }

    public static function clientOngoingCount($user_id)
    {
        return self::where('user_id', $user_id)->where('job_status', 2)->count();
    }

    public static function jobCount()
    {
        return self::count();
    }
}
