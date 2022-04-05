<?php

namespace Modules\Setting\Model;

use Illuminate\Database\Eloquent\Model;
use Modules\Localization\Entities\Language;

class GeneralSetting extends Model
{
    protected $guarded = [];

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    /*    public function currency()
        {
            return $this->belongsTo(Currency::class);
        }*/

    public function currencyDetails()
    {
        return $this->belongsTo(Currency::class, 'currency', 'id');
    }

    public function dateFormat()
    {
        return $this->belongsTo(DateFormat::class);
    }

    public function timeZone()
    {
        return $this->belongsTo(TimeZone::class);
    }

    public function smsGateway()
    {
        return $this->belongsTo(SmsGateway::class);
    }
}
