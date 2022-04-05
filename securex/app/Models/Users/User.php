<?php

namespace App\Models\Users;

use App\Http\Traits\EncryptAttributes;
use App\Models\Vaults\Site;
use App\Models\Vaults\Vault;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Jenssegers\Agent\Agent;
use Spargon\AuthLogger\AuthLogable;

class User extends Authenticatable implements MustVerifyEmail
{
    use AuthLogable;
    use EncryptAttributes;
    use HasFactory;
    use Notifiable;

    const ADMIN_TYPE = 'admin';
    const DEFAULT_TYPE = 'user';

    /**
     * The attributes that should be encrypted and decrypted on the fly.
     *
     * @var array
     */
    protected $encrypted = ['google2fa_secret', 'support_pin'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'email_verified_at', 'password', 'password_hint', 'oauth', 'oauth_id', 'phone', 'dob', 'address_line1', 'address_line2', 'city', 'zipcode', 'state', 'country', 'avatar', 'two_factor_enabled', 'two_factor_secret', 'two_factor_recovery_codes', 'status', 'security_questions', 'rng_level', 'support_pin', 'type', 'remark', 'remark_date', 'access_key',
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
        'delete_on' => 'datetime',
    ];

    /**
     * Defining preferred locale for the user.
     */
    public function preferredLocale()
    {
        return $this->locale;
    }

    /**
     * The Authentication Log notifications delivery channels.
     *
     * @return array
     */
    public function notifyAuthenticationLogVia()
    {
        return ['mail'];
    }

    /**
     * Check if a user is an Admin and return true.
     */
    public function isAdmin()
    {
        return $this->type === self::ADMIN_TYPE;
    }

    /**
     * Relation between a user and vaults.
     * A user can have many vaults.
     */
    public function vaults()
    {
        return $this->hasMany(Vault::class)->orderBy('created_at', 'DESC');
    }

    /**
     * Relation between a user and sites.
     * A user can have many sites.
     */
    public function sites()
    {
        return $this->hasMany(Site::class)->orderBy('created_at', 'DESC');
    }

    /**
     * Relation between a user and notes.
     * A user can have many notes.
     */
    public function notes()
    {
        return $this->hasMany(Note::class)->orderBy('created_at', 'DESC');
    }

    /**
     * Relation between a User & a Security Question entry.
     * A user has one security question entry.
     */
    public function questions()
    {
        return $this->hasOne(SecurityQuestion::class);
    }

    /**
     * Returns total count of sites.
     */
    public function total_sites()
    {
        $count = 0;

        foreach ($this->vaults as $vault) {
            $count = $count + $vault->sites_count;
        }

        return $count;
    }

    /**
     * Returns total count of notes.
     */
    public function total_notes()
    {
        $count = 0;

        foreach ($this->vaults as $vault) {
            foreach ($vault->sites as $site) {
                $count = $count + $site->notes->count();
            }
        }

        return $count;
    }

    /**
     * Returns total count of folders.
     */
    public function total_folders()
    {
        $count = 0;

        foreach ($this->vaults as $vault) {
            $count = $count + $vault->folders_count;
        }

        return $count;
    }

    /**
     * Return if a user profile is incomplete.
     */
    public function profile_incomplete()
    {
        $attributes = ['first_name', 'last_name', 'phone', 'dob', 'address_line1', 'city', 'zipcode', 'state', 'country'];

        foreach ($attributes as $attr) {
            if (empty($this->$attr)) {
                return true;
            }
        }

        return false;
    }

    /**
     * A user can have many mark for deletion logs.
     */
    public function mark_for_deletion_logs()
    {
        return $this->hasMany(MarkForDeletionLog::class);
    }

    /**
     * Return true if the user has reached the Vaults limit.
     */
    public function hasReachedVaultLimit()
    {
        return $this->vaults->count() >= setting()->get('max_vaults');
    }

    /**
     * Return true if the user has reached the Sites limit.
     */
    public function hasReachedSiteLimit()
    {
        return $this->total_sites() >= setting()->get('max_sites');
    }

    /**
     * Return true if the user has reached the Folders limit.
     */
    public function hasReachedFolderLimit()
    {
        return $this->total_folders() >= setting()->get('max_folders');
    }

    /**
     * Return true if the user has reached the Notes limit.
     */
    public function hasReachedNoteLimit()
    {
        return $this->notes->count() >= setting()->get('max_notes');
    }

    /**
     * Relation between a User & Authentication Logs.
     * A user has many authentication logs.
     */
    public function authentication_logs()
    {
        return $this->hasMany(AuthenticationLog::class, 'authenticatable_id');
    }

    /**
     * Load all the sites in a particular vault owned by the User.
     */
    public function allSites()
    {
        $sites = $this->vaults->load('sites');

        return $sites;
    }

    /**
     * Parse the given user agent and return human readable data.
     */
    public function parse_agent($user_agent)
    {
        $agent = new Agent();

        $agent->setUserAgent($user_agent);

        return $agent;
    }
}
