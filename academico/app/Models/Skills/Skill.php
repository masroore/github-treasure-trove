<?php

namespace App\Models\Skills;

use App\Models\EvaluationType;
use App\Models\Level;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Skills\Skill.
 *
 * @property int $id
 * @property string $name
 * @property int $default_weight
 * @property int $level_id
 * @property int $skill_type_id
 * @property null|\Illuminate\Support\Carbon $created_at
 * @property null|\Illuminate\Support\Carbon $updated_at
 * @property null|string $deleted_at
 * @property null|int $order
 * @property mixed $complete_name
 * @property Level $level
 * @property EvaluationType[]|\Illuminate\Database\Eloquent\Collection $presets
 * @property null|int $presets_count
 * @property \App\Models\Skills\SkillEvaluation[]|\Illuminate\Database\Eloquent\Collection $skill_evaluations
 * @property null|int $skill_evaluations_count
 * @property \App\Models\Skills\SkillType $skill_type
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Skill newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Skill newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Skill query()
 * @method static \Illuminate\Database\Eloquent\Builder|Skill whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skill whereDefaultWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skill whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skill whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skill whereLevelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skill whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skill whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skill whereSkillTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skill whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Skill extends Model
{
    use CrudTrait;

    protected $guarded = ['id'];

    protected $with = ['level', 'skill_type'];

    protected $appends = ['complete_name'];

    /** The category the skill belongs to */
    public function skill_type()
    {
        return $this->belongsTo(SkillType::class);
    }

    /** A skill belongs to a level, this allows to filter available skills when attaching them to courses */
    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    /** A skill is linked to skill evaluations (themselves linked to enrollments) */
    public function skill_evaluations()
    {
        return $this->hasMany(SkillEvaluation::class);
    }

    public function presets()
    {
        return $this->morphToMany(EvaluationType::class, 'presettable', 'evaluation_type_presets');
    }

    public function getCompleteNameAttribute(): string
    {
        return '[' . ($this->level->name ?? '') . '] ' . ($this->skill_type->shortname ?? '') . ' - ' . $this->name ?? '';
    }
}
