<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $settings;

    protected $fillable = [
        'name',
        'company_name',
        'email',
        'password',
        'type',
        'avatar',
        'lang',
        'created_by',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     * 'plan',.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function currentLanguage()
    {
        return $this->lang;
    }

    public function creatorId()
    {
        if ('company' == $this->type || 'super admin' == $this->type) {
            return $this->id;
        }

        return $this->created_by;
    }

    public function employeeIdFormat($number)
    {
        $settings = Utility::settings();

        return $settings['employee_prefix'] . sprintf('%05d', $number);
    }

    public function getBranch($branch_id)
    {
        return Branch::where('id', '=', $branch_id)->first();
    }

    public function getLeaveType($leave_type)
    {
        return LeaveType::where('id', '=', $leave_type)->first();
    }

    public function getEmployee($employee)
    {
        return Employee::where('id', '=', $employee)->first();
    }

    public function getDepartment($department_id)
    {
        return Department::where('id', '=', $department_id)->first();
    }

    public function getDesignation($designation_id)
    {
        return Designation::where('id', '=', $designation_id)->first();
    }

    public function getUser($user)
    {
        return self::where('id', '=', $user)->first();
    }

    public function userEmployee()
    {
        return self::select('id')->where('created_by', '=', Auth::user()->creatorId())->where('type', '=', 'employee')->get();
    }

    public function getUSerEmployee($id)
    {
        return Employee::where('user_id', '=', $id)->first();
    }

    public function priceFormat($price)
    {
        $settings = Utility::settings();

        return (('pre' == $settings['site_currency_symbol_position']) ? $settings['site_currency_symbol'] : '') . number_format($price, 2) . (('post' == $settings['site_currency_symbol_position']) ? $settings['site_currency_symbol'] : '');
    }

    public function currencySymbol()
    {
        $settings = Utility::settings();

        return $settings['site_currency_symbol'];
    }

    public function dateFormat($date)
    {
        $settings = Utility::settings();

        return date($settings['site_date_format'], strtotime($date));
    }

    public function timeFormat($time)
    {
        $settings = Utility::settings();

        return date($settings['site_time_format'], strtotime($time));
    }

    public function getPlan()
    {
        return $this->hasOne('App\Models\Plan', 'id', 'plan');
    }

    public function assignPlan($planID)
    {
        $plan = Plan::find($planID);
        if ($plan) {
            $this->plan = $plan->id;
            if ('month' == $plan->duration) {
                $this->plan_expire_date = Carbon::now()->addMonths(1)->isoFormat('YYYY-MM-DD');
            } elseif ('year' == $plan->duration) {
                $this->plan_expire_date = Carbon::now()->addYears(1)->isoFormat('YYYY-MM-DD');
            } else {
                $this->plan_expire_date = null;
            }
            $this->save();

            $users = self::where('created_by', '=', \Auth::user()->creatorId())->where('type', '!=', 'super admin')->where('type', '!=', 'company')->where('type', '!=', 'employee')->get();
            $employees = self::where('created_by', '=', \Auth::user()->creatorId())->where('type', 'employee')->get();

            if (-1 == $plan->max_users) {
                foreach ($users as $user) {
                    $user->is_active = 1;
                    $user->save();
                }
            } else {
                $userCount = 0;
                foreach ($users as $user) {
                    $userCount++;
                    if ($userCount <= $plan->max_users) {
                        $user->is_active = 1;
                        $user->save();
                    } else {
                        $user->is_active = 0;
                        $user->save();
                    }
                }
            }

            if (-1 == $plan->max_employees) {
                foreach ($employees as $employee) {
                    $employee->is_active = 1;
                    $employee->save();
                }
            } else {
                $employeeCount = 0;
                foreach ($employees as $employee) {
                    $employeeCount++;
                    if ($employeeCount <= $plan->max_employees) {
                        $employee->is_active = 1;
                        $employee->save();
                    } else {
                        $employee->is_active = 0;
                        $employee->save();
                    }
                }
            }

            return ['is_success' => true];
        }

        return [
                'is_success' => false,
                'error' => 'Plan is deleted.',
            ];
    }

    public function countUsers()
    {
        return self::where('type', '!=', 'super admin')->where('type', '!=', 'company')->where('type', '!=', 'employee')->where('created_by', '=', $this->creatorId())->count();
    }

    public function countEmployees()
    {
        return Employee::where('created_by', '=', $this->creatorId())->count();
    }

    public function countCompany()
    {
        return self::where('type', '=', 'company')->where('created_by', '=', $this->creatorId())->count();
    }

    public function countOrder()
    {
        return Order::count();
    }

    public function countplan()
    {
        return Plan::count();
    }

    public function countPaidCompany()
    {
        return self::where('type', '=', 'company')->whereNotIn(
            'plan',
            [
                      0,
                      1,
                  ]
        )->where('created_by', '=', \Auth::user()->id)->count();
    }

    public function planPrice()
    {
        $user = \Auth::user();
        if ('super admin' == $user->type) {
            $userId = $user->id;
        } else {
            $userId = $user->created_by;
        }

        return \DB::table('settings')->where('created_by', '=', $userId)->get()->pluck('value', 'name');
    }

    public function currentPlan()
    {
        return $this->hasOne('App\Models\Plan', 'id', 'plan');
    }

    public function unread()
    {
        return Message::where('from', '=', $this->id)->where('is_read', '=', 0)->count();
    }

    public function employee()
    {
        return $this->hasOne('App\Models\Employee', 'user_id', 'id');
    }
}
