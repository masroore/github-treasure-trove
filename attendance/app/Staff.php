<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable = ['user_id', 'fullname', 'dateofbirth', 'address', 'faculty', 'gender', 'religion', 'qualification', 'number', 'fathername', 'mothername', 'maritalstatus', 'workexperience', 'eployid', 'salarygrade', 'salary', 'acctitle', 'accnum', 'bankname', 'bankbranch', 'resumedoc', 'role'];

    public function user()
    {
        return $this->belongsto('App\User');
    }

    public function payroll()
    {
        return $this->hasMany('App\Payroll');
    }

    public function getimage($userid)
    {
        $user = User::where('id', $userid)->first();

        return $user->pro_pic;
    }
}
