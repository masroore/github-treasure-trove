<?php

namespace Modules\Payroll\Entities;

use App\Staff;
use App\User;
use Auth;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Modules\RolePermission\Entities\Role;

class Payroll extends Model
{
    protected $table = 'payrolls';

    protected $guarded = ['id'];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function payroll_earn_deducs()
    {
        return $this->hasMany(PayrollEarnDeduce::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public static function boot(): void
    {
        parent::boot();
        static::saving(function ($brand): void {
            $brand->created_by = Auth::user()->id ?? null;
        });

        static::updating(function ($brand): void {
            $brand->updated_by = Auth::user()->id ?? null;
        });
    }

    public static function getPayrollDetails($staff_id, $payroll_month, $payroll_year)
    {
        try {
            $getPayrollDetails = self::with('staff.department', 'staff.user')
                ->where('staff_id', $staff_id)
                ->where('payroll_month', $payroll_month)
                ->where('payroll_year', $payroll_year)
                ->first();

            if (isset($getPayrollDetails)) {
                return $getPayrollDetails;
            }

            return false;
        } catch (Exception $e) {
            return false;
        }
    }
}
