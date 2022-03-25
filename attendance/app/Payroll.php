<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $fillable = ['user_id', 'role', 'month', 'monthalise', 'year', 'earning', 'earnamnts', 'totalearn', 'deduction', 'deductamnts', 'totalded', 'grosssalary', 'netsalary', 'tax', 'status', 'paymentdate', 'note', 'modepay', 'payslipid'];

    public function staff()
    {
        return $this->belongsto('App\Staff', 'user_id');
    }
}
