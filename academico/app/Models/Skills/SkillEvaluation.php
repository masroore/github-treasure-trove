<?php

namespace App\Models\Skills;

use App\Models\Enrollment;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Skills\SkillEvaluation.
 *
 * @property int $id
 * @property null|int $course_id
 * @property null|int $student_id
 * @property null|int $enrollment_id
 * @property int $skill_scale_id
 * @property int $skill_id
 * @property null|\Illuminate\Support\Carbon $created_at
 * @property null|\Illuminate\Support\Carbon $updated_at
 * @property null|string $deleted_at
 * @property null|Enrollment $enrollment
 * @property \App\Models\Skills\Skill $skill
 * @property \App\Models\Skills\SkillScale $skill_scale
 *
 * @method static \Illuminate\Database\Eloquent\Builder|SkillEvaluation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SkillEvaluation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SkillEvaluation query()
 * @method static \Illuminate\Database\Eloquent\Builder|SkillEvaluation whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkillEvaluation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkillEvaluation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkillEvaluation whereEnrollmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkillEvaluation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkillEvaluation whereSkillId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkillEvaluation whereSkillScaleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkillEvaluation whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkillEvaluation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SkillEvaluation extends Model
{
    protected $guarded = ['id'];

    protected $with = ['skill', 'skill_scale'];

    use CrudTrait;

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function skill_scale()
    {
        return $this->belongsTo(SkillScale::class);
    }
}
