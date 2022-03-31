<?php

namespace App\Models;

use App\Traits\Auditable;
use App\Traits\MultiTenantModelTrait;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropoertyInquiry extends Model
{
    use Auditable;
    use HasFactory;
    use MultiTenantModelTrait;
    use SoftDeletes;

    public $table = 'propoerty_inquiries';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'property_id',
        'full_name',
        'phone_number',
        'email_address',
        'message',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by_id',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
