<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Contact.
 *
 * @property int $id
 * @property int $student_id
 * @property string $firstname
 * @property string $lastname
 * @property string $idnumber
 * @property string $address
 * @property null|string $email
 * @property null|int $relationship_id
 * @property null|int $profession_id
 * @property null|\Illuminate\Support\Carbon $created_at
 * @property null|\Illuminate\Support\Carbon $updated_at
 * @property string $locale
 * @property \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property null|int $activities_count
 * @property mixed $name
 * @property \App\Models\PhoneNumber[]|\Illuminate\Database\Eloquent\Collection $phone
 * @property null|int $phone_count
 * @property null|\App\Models\Profession $profession
 * @property null|\App\Models\ContactRelationship $relationship
 * @property \App\Models\Student $student
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Contact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact query()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereIdnumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereProfessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereRelationshipId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Contact extends Model
{
    use CrudTrait;
    use LogsActivity;

    protected $fillable = ['firstname', 'lastname', 'idnumber', 'address', 'email', 'relationship_id', 'profession_id', 'student_id'];

    protected $with = ['phone', 'relationship', 'profession'];

    protected $appends = ['name'];

    protected static $logUnguarded = true;

    public function phone()
    {
        return $this->morphMany(PhoneNumber::class, 'phoneable');
    }

    public function getNameAttribute()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function relationship()
    {
        return $this->belongsTo(ContactRelationship::class);
    }

    public function profession()
    {
        return $this->belongsTo(Profession::class);
    }
}
