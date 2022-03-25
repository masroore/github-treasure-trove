<?php

namespace App;

use APP\Lecturer;
use App\Notifications\CustomPasswordReset;
use Bavix\Wallet\Interfaces\Wallet;
use Bavix\Wallet\Traits\CanConfirm;
use Bavix\Wallet\Traits\CanPay;
use Bavix\Wallet\Traits\HasWallet;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements Wallet
{
    use CanConfirm;
    use CanPay;
    use HasRoles;
    use HasWallet;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'indexnumber',
        'force_logout', 'is_active', 'pro_pic', 'regemail',
    ];

    /**
     * Spartie Customizing the log name.
     */
    protected static $logName = 'User';

    /**
     * Spartie Log Attribues.
     */
    protected static $logAttributes = ['email', 'name'];

    /**
     * Spartie Record Events For.
     */
    protected static $recordEvents = ['deleted', 'created', 'updated'];

    /**
     * Spartie Logging only the changed attributes.
     */
    protected static $logOnlyDirty = true;

    /**
     * Spartie Prevent save logs items that have no changed attribute.
     */
    protected static $submitEmptyLogs = false;

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

    /**
     * Attributes to exclude from the Audit.
     *
     * @var array
     */
    protected $auditExclude = [
        'password', 'remember_token',
    ];

    /**
     * Spartie Customizing the description.
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        return "This user Information has been {$eventName}";
    }

    public function studentinfos()
    {
        return $this->hasOne('App\Studentinfo');
    }

    public function regacademicyear()
    {
        return $this->hasMany('App\Regacademicyear', 'user_id');
    }

    public function Coureregistration()
    {
        return $this->hasMany('App\Coureregistration', 'user_id');
    }

    public function examresults()
    {
        return $this->hasMany('App\Examresults', 'user_id');
    }

    //this method is for the custom mail send notification.the method bmust be the same has laravel default method
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomPasswordReset($token));
    }

    public function lectures()
    {
        return $this->hasMany('App\Lecturer');
    }

    public function studentgrouping()
    {
        return $this->hasMany('App\Studentgrouping', 'indexnumber', 'indexnumber');
    }

    public function staff()
    {
        return $this->hasOne('App\Staff', 'user_id');
    }

    public function getappLectures($id)
    {
        return Lecturer::where('user_id', $id)->get();
    }

    public function regsemesters()
    {
        return Regacademicyear::where('user_id', auth()->user()->id)->get();
    }

    public function getimage($id)
    {
    }

    /**
     * Determine if the user is an administrator.
     *
     * @return bool
     */
    public function isAdmin()
    {
        // return $this->getRoleNames()[0];
        return $this->hasRole('is_admin|is_superAdmin');
    }

    /**
     * Determine if the user is an administrator.
     *
     * @return bool
     */
    public function islecturer()
    {
        // return $this->getRoleNames()[0];
        return $this->hasRole('Lecturer|is_admin|is_superAdmin');
    }

    /**
     * Determine if the user is an administrator.
     *
     * @return bool
     */
    public function isHr()
    {
        // return $this->getRoleNames()[0];
        return $this->hasRole('Human Resource|is_admin|is_superAdmin');
    }

    /**
     * Determine if the user is a Student.
     *
     * @return bool
     */
    public function isStudent()
    {
        // return $this->getRoleNames()[0];
        return $this->hasRole('Student|is_admin|is_superAdmin');
    }

    /**
     * Determine if the user is an Admissioncommittee Officer.
     *
     * @return bool
     */
    public function isAdmissioncommittee()
    {
        // return $this->getRoleNames()[0];
        return $this->hasRole('Admission committee|is_admin|is_superAdmin');
    }

    /**
     * Determine if the user is a Nationalservice Officer.
     *
     * @return bool
     */
    public function isNationalservice()
    {
        // return $this->getRoleNames()[0];
        return $this->hasRole('National Service|is_admin|is_superAdmin');
    }

    /**
     * Determine if the user is an Accounts Officer.
     *
     * @return bool
     */
    public function isAccounts()
    {
        // return $this->getRoleNames()[0];
        return $this->hasRole('Accounts|is_admin|is_superAdmin');
    }

    /**
     * Determine if the user is a Nabco Officer.
     *
     * @return bool
     */
    public function isNabco()
    {
        // return $this->getRoleNames()[0];
        return $this->hasRole('Nabco Trainee|is_admin|is_superAdmin');
    }

    /**
     * Determine if the user is a Front_desk_help Officer.
     *
     * @return bool
     */
    public function isFront_desk_help()
    {
        // return $this->getRoleNames()[0];
        return $this->hasRole('Front_desk_help|is_admin|is_superAdmin');
    }

    /**
     * Determine if the user is a Front_desk_help Officer.
     *
     * @return bool
     */
    public function isItHrAccountsAdmission()
    {
        // return $this->getRoleNames()[0];
        return $this->hasRole('is_admin|is_superAdmin|Accounts|Human Resource|Admission committee');
    }

    /**
     * Determine if the user is a Accounts Lecturer.
     *
     * @return bool
     */
    public function isAccountLecturer()
    {
        // return $this->getRoleNames()[0];
        return $this->hasRole('Accounts|is_admin|is_superAdmin|Lecturer');
    }
}
