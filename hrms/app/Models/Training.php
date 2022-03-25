<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    public static $options = [
        'Internal',
        'External',
    ];

    public static $performance = [
        'Not Concluded',
        'Satisfactory',
        'Average',
        'Poor',
        'Excellent',
    ];

    public static $Status = [
        'Pending',
        'Started',
        'Completed',
        'Terminated',
    ];
    protected $fillable = [
        'branch',
        'trainer_option',
        'training_type',
        'trainer',
        'training_cost',
        'employee',
        'start_date',
        'end_date',
        'description',
        'created_by',
    ];

    public function branches()
    {
        return $this->hasOne('App\Models\Branch', 'id', 'branch');
    }

    public function types()
    {
        return $this->hasOne('App\Models\TrainingType', 'id', 'training_type');
    }

    public function employees()
    {
        return $this->hasOne('App\Models\Employee', 'id', 'employee');
    }

    public function trainers()
    {
        return $this->hasOne('App\Models\Trainer', 'id', 'trainer');
    }

    public static function status($status)
    {
        if ('0' == $status) {
            return 'Pending';
        }
        if ('1' == $status) {
            return 'Started';
        }
        if ('2' == $status) {
            return 'Completed';
        }
        if ('3' == $status) {
            return 'Terminated';
        }
    }
}
