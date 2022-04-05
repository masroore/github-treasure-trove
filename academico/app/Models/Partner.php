<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Partner.
 *
 * @property int $id
 * @property string $name
 * @property null|string $started_on
 * @property null|string $expired_on
 * @property null|int $send_report_on
 * @property null|string $last_alert_sent_at
 * @property null|int $auto_renewal
 * @property null|\Illuminate\Support\Carbon $created_at
 * @property null|\Illuminate\Support\Carbon $updated_at
 * @property Course[]|\Illuminate\Database\Eloquent\Collection $courses
 * @property null|int $courses_count
 * @property mixed $formatted_end_date
 * @property mixed $formatted_start_date
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Partner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Partner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Partner query()
 * @method static \Illuminate\Database\Eloquent\Builder|Partner whereAutoRenewal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partner whereExpiredOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partner whereLastAlertSentAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partner whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partner whereSendReportOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partner whereStartedOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partner whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Partner extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $guarded = ['id'];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function getFormattedStartDateAttribute()
    {
        if (!$this->started_on) {
            return '-';
        }

        return Carbon::parse($this->started_on)->locale(app()->getLocale())->isoFormat('Do MMM YYYY');
    }

    public function getFormattedEndDateAttribute()
    {
        if (!$this->expired_on) {
            return '-';
        }

        return Carbon::parse($this->expired_on)->locale(app()->getLocale())->isoFormat('Do MMM YYYY');
    }
}
