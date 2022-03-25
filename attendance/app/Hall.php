<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Hall extends Model
{
    use LogsActivity;

    protected $fillable = ['name', 'capacity'];

    /**
     * Spartie Customizing the log name.
     */
    protected static $logName = 'Hall';

    /**
     * Spartie Log Attribues.
     */
    protected static $logAttributes = ['capacity', 'name'];

    /**
     * Spartie Record Events For.
     */
    protected static $recordEvents = ['deleted', 'created', 'updated'];

    /**
     * Spartie Logging only the changed attributes.
     */
    protected static $logOnlyDirty = true;

    /**
     * Spartie Prevent save logs items that have no changed attribute.
     */
    protected static $submitEmptyLogs = false;

    /**
     * Spartie Customizing the description.
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        return "{$eventName}";
    }
}
