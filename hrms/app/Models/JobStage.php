<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;

class JobStage extends Model
{
    protected $fillable = [
        'title',
        'order',
        'created_by',
    ];

    public function applications($filter)
    {
        $application = JobApplication::where('created_by', Auth::user()->creatorId())->where('is_archive', 0)->where('stage', $this->id);
        $application->where('created_at', '>=', $filter['start_date']);
        $application->where('created_at', '<=', $filter['end_date']);

        if (!empty($filter['job'])) {
            $application->where('job', $filter['job']);
        }

        return $application->orderBy('order')->get();
    }
}
