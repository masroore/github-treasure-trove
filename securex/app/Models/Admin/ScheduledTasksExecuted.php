<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduledTasksExecuted extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'command', 'ran_at', 'status'];

    /**
     * Database table to be used by this model.
     */
    protected $table = 'scheduled_tasks_excecuted';

    /**
     * Casting attributes to specific types.
     */
    protected $casts = [
        'ran_at' => 'datetime',
    ];
}
