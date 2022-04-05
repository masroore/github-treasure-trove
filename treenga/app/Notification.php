<?php

namespace App;

use Illuminate\Notifications\DatabaseNotification;

class Notification extends DatabaseNotification
{
    protected static function boot(): void
    {
        parent::boot();

        static::deleted(function ($model): void {
            $model->categories()->detach();
            $model->tasks()->detach();
            $model->teams()->detach();
        });
    }

    // Start Relations
    public function categories()
    {
        return $this->morphedByMany(Category::class, 'notifyables');
    }

    public function tasks()
    {
        return $this->morphedByMany(Task::class, 'notifyables');
    }

    public function teams()
    {
        return $this->morphedByMany(Team::class, 'notifyables');
    }
    // End Relations

    // Start Scopes
    // End Scopes

    // Start Mutators
    // End Mutators

    // Start Helper
    // End Helper
}
