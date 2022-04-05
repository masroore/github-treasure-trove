<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Activitylog\Traits\LogsActivity;

class Coureregistration extends Model implements Auditable
{
    use LogsActivity;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['user_id', 'indexnumber', 'lecturer_id', 'cource_code', 'cource_title', 'credithours', 'IA_mark', 'exams_mark', 'total_marks', 'grade', 'grade_point', 'total_gp',
        'semester', 'academic_year', 'status', 'level', 'resit', 'session', 'fvrt', ];

    protected static $logName = 'Coureregistration';

    /**
     * Spartie Log Attribues.
     */
    protected static $logAttributes = ['lecturer_id', 'cource_code', 'cource_title', 'IA_mark', 'exams_mark', 'total_marks', 'grade', 'grade_point', 'total_gp', 'semester', 'academic_year', 'level', 'indexnumber'];

    /**
     * Spartie Record Events For.
     */
    protected static $recordEvents = ['deleted', 'created', 'updated'];

    protected static $logOnlyDirty = true;
}
