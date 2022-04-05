<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmailSettingUpdateForm extends FormRequest
{
    // Route to redirect user to on validation failure.
    protected $redirectAction = 'Admin\Settings\EmailSettingController@index';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'mail_driver' => 'required',
            'mail_from_address' => 'required',
            'mail_from_name' => 'required',
            'mail_host' => 'required_if:mail_driver,smtp',
            'mail_port' => 'required_if:mail_driver,smtp|numeric|nullable',
            'mail_encryption' => 'required_if:mail_driver,smtp',
            'mail_username' => 'required_if:mail_driver,smtp',
            'mail_password' => 'required_if:mail_driver,smtp',
            'mailgun_domain' => 'required_if:mail_driver,mailgun',
            'mailgun_secret' => 'required_if:mail_driver,mailgun',
        ];
    }
}
