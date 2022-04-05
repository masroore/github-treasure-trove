<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class UniqueUserDataForDomain implements Rule
{
    protected $column;

    protected $userId;

//    protected $domainUrl;
    /**
     * Create a new rule instance.
     */
    public function __construct($column, $userId = null, $domainUrl = null)
    {
        $this->column = $column;
        $this->userId = $userId === null ? auth()->user()->id : $userId;
//        $this->domainUrl = $domainUrl === null ? request()->header('client') : $domainUrl;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $users = User::where($this->column, $value)
            ->when($this->userId, function ($q): void {
                $q->where('id', '<>', $this->userId);
            })
//            ->when($this->domainUrl, function ($q) {
//                $q->where('domain', '=', $this->domainUrl);
//            })
            ->count();

        return !$users;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if ($this->column == 'nickname') {
            return trans('system.nickname.already');
        }

        if ($this->column == 'email') {
            return trans('system.user.email.already');
        }

        if ($this->column == 'phone') {
            return trans('system.user.phone.already');
        }

        return 'Invalid data';
    }
}
