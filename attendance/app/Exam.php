<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Exam extends Model
{
    use LogsActivity;

    protected $fillable = ['title', 'totalquestion', 'mfr', 'mfw', 'minutes', 'description', 'programme', 'coursecode', 'lecturer_id', 'questiontoshow', 'retry', 'academicyear', 'semester', 'fullname'];

    /**
     * Spartie Customizing the log name.
     */
    protected static $logName = 'Exam';

    /**
     * Spartie Log Attribues.
     */
    protected static $logAttributes = ['title', 'totalquestion', 'minutes', 'description', 'programme', 'coursecode', 'questiontoshow', 'retry'];

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
        return "This user Information has been {$eventName}";
    }
}
