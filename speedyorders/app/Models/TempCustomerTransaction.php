<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TempCustomerTransaction extends Model
{
    protected $table = 'temp_customer_transaction';

    protected $fillable = [
        'php_session_id', 'description', 'amount', 'type', 'status', 'created_at',
    ];
}
