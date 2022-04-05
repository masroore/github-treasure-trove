<?php

namespace Modules\Project\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Task extends Model
{
    use LogsActivity;

    protected $table = 'tasks';

    protected static $logName = 'task';

    protected static $logFillable = true;

    protected static $logOnlyDirty = true;

    protected static $ignoreChangedAttributes = ['updated_at', 'completed_at', 'incompleted_at', 'completed_by', 'incompleted_by'];

    protected static $submitEmptyLogs = false;

    protected $fillable = [
        'project_id',
        'section_id',
        'user_id',
        'name',
        'order',
    ];

    protected $with = ['creator', 'all_fields', 'comments', 'likes', 'pined_comments'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function fields()
    {
        $project = $this->project()->with('visible_fields')->first();
        $fields = $project->visible_fields()->pluck('field_id');

        if (count($fields)) {
            $ids = '';
            foreach ($fields as $field) {
                $ids .= $field . ',';
            }
            $ids = rtrim($ids, ',');

            return $this->belongsToMany(Field::class, FieldTask::class)->with('options', 'pivot.option', 'pivot.assinge')->withPivot(['date', 'user_id', 'option_id', 'number', 'text'])->whereIn('field_id', $fields)->orderByRaw("FIELD(field_id, $ids)");
        }

        return $this->belongsToMany(Field::class, FieldTask::class)->with('options', 'pivot.option', 'pivot.assinge')->withPivot(['date', 'user_id', 'option_id', 'number', 'text'])->whereIn('field_id', $fields);
    }

    public function all_fields()
    {
        return $this->belongsToMany(Field::class, FieldTask::class)->with('options', 'pivot.option', 'pivot.assinge')->withPivot(['date', 'user_id', 'option_id', 'number', 'text']);
    }

    public function tasks()
    {
        return $this->hasMany(self::class, 'parent_id', 'id')->with('fields', 'tags', 'tasks')->orderBy('order');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_task', 'task_id', 'tag_id');
    }

    public function comments()
    {
        return $this->hasMany(TaskComment::class);
    }

    public function pined_comments()
    {
        return $this->hasMany(TaskComment::class)->where('pin_top', 1);
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'task_likes');
    }
}
