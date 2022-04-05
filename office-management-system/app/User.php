<?php

namespace App;

use App\Notifications\PasswordResetNotification;
use App\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Modules\Account\Entities\ChartAccount;
use Modules\Attendance\Entities\Attendance;
use Modules\Contact\Entities\ContactModel;
use Modules\Leave\Entities\ApplyLeave;
use Modules\Leave\Entities\LeaveDefine;
use Modules\Project\Entities\Project;
use Modules\Project\Entities\Team;
use Modules\Project\Traits\HasWorkspaces;
use Modules\RolePermission\Entities\Role;
use Modules\Sale\Entities\Sale;
use Modules\Setup\Entities\ApplyLoan;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasWorkspaces;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'role_id', 'password', 'avatar', 'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function staff()
    {
        return $this->hasOne(Staff::class);
    }

    public function agent()
    {
        return $this->hasOne(Agent::class);
    }

    public function contact()
    {
        return $this->belongsTo(ContactModel::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class, 'agent_user_id');
    }

    public function accounts()
    {
        return $this->morphMany(ChartAccount::class, 'contactable');
    }

    public function loans()
    {
        return $this->hasMany(ApplyLoan::class)->where('approval', 1);
    }

    public function getLoanInfoAttribute()
    {
        $loans = $this->loans;

        $total_loan = $loans->sum('amount');

        $total_paid = $loans->sum('paid_loan_amount');

        $total_due = $total_loan - $total_paid;

        return [
            'total_loan' => $total_loan,
            'total_paid' => $total_paid,
            'total_due' => $total_due,
        ];
    }

    public function getAccountsAttribute()
    {
        $sales = $this->sales;
        $payable_amount = $sales->sum('payable_amount');

        $paid_amount = 0;
        $sales_return_amount = 0;
        $debit_amount = 0;
        $crebit_amount = 0;
        $total_amount = 0;
        $chart_account = ChartAccount::where('contactable_type', 'App\User')->where('contactable_id', $this->id)->first();
        $sales = $this->sales;
        $payable_amount = $sales->sum('payable_amount');

        foreach ($sales as $sale) {
            $paid_amount += ($sale->payments->sum('amount') - $sale->payments->sum('return_amount'));
            $sales_return_amount += $sale->items->sum('return_amount');
        }
        $total_amount = $payable_amount + $this->agent->opening_balance - $sales_return_amount;
        $due_amount = $chart_account->BalanceAmount + $this->agent->opening_balance;

        $accounts['total'] = $total_amount;
        $accounts['paid'] = $paid_amount;
        $accounts['due'] = $due_amount;
        $accounts['total_invoice'] = count($sales);
        $accounts['due_invoice'] = count($sales->where('status', '!=', 1));

        return $accounts;
    }

    public function leaves()
    {
        return $this->hasMany(ApplyLeave::class)->CarryForward();
    }

    public function leaveDefines()
    {
        return $this->hasMany(LeaveDefine::class, 'role_id', 'role_id');
    }

    public function getCarryForwardAttribute()
    {
        $total_leave = $this->leaveDefines->sum('total_days');
        $leave = $this->leaves->sum('total_days');

        return $total_leave - $leave;
    }

    public function lastInvoice()
    {
        return $this->hasOne(Sale::class, 'agent_user_id')->latest();
    }

    public function getSaleDetailsAttribute()
    {
        $paid_amount = 0;
        $sales_return_amount = 0;
        $debit_amount = 0;
        $crebit_amount = 0;
        $total_amount = 0;
        $opening_balance = $this->opening_balance ?: 0;

        $sales = $this->sales;
        $payable_amount = $sales->sum('payable_amount');

        $chart_account = ChartAccount::where('contactable_type', 'App\User')->where('contactable_id', $this->id)->first();

        foreach ($sales as $sale) {
            $paid_amount += ($sale->payments->sum('amount') - $sale->payments->sum('return_amount'));
            $sales_return_amount += $sale->items->sum('return_amount');
        }
        $total_amount = $payable_amount + $opening_balance - $sales_return_amount;
        $due_amount = $chart_account->BalanceAmount + $opening_balance;

        $accounts['total'] = $total_amount;
        $accounts['paid'] = $paid_amount;
        $accounts['due'] = $due_amount;
        $accounts['total_invoice'] = count($sales);
        $accounts['due_invoice'] = count($sales->where('is_approved', 0));

        return $accounts;
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team_user', 'user_id', 'team_id');
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_user', 'user_id', 'project_id');
    }

    /**
     * Get the URL to the user's profile photo.
     *
     * @return string
     */
    public function getProfilePhotoUrlAttribute()
    {
        return $this->avatar
            ? asset($this->avatar)
            : $this->defaultProfilePhotoUrl();
    }

    /**
     * Get the default profile photo URL if no profile photo has been uploaded.
     *
     * @return string
     */
    protected function defaultProfilePhotoUrl()
    {
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }

    /**
     * Get the disk that profile photos should be stored on.
     *
     * @return string
     */
    protected function profilePhotoDisk()
    {
        return isset($_ENV['VAPOR_ARTIFACT_NAME']) ? 's3' : 'public';
    }

    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new PasswordResetNotification($token));
    }

    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new VerifyEmail());
    }
}
