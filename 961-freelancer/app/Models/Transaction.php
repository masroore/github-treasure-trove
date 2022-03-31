<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
      'trans_id',
      'user_id',
      'token',
      'gross_amt',
      'fee_amt',
      'net_amt',
      'payer_id',
      'email',
      'currency_code',
      'country_code',
      'status',
    ];

    // public function job(){
    //   return $this->belongsTo(Job::class, 'job_id', 'job_id');
    // }
    public function totalFee()
    {
        return self::sum('fee_amt');
    }

    public function totalAmount()
    {
        return self::sum('gross_amt');
    }

    public function avgAmount()
    {
        return self::avg('gross_amt');
    }
}
