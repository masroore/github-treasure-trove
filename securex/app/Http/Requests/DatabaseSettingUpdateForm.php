<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;

class DatabaseSettingUpdateForm extends FormRequest
{
    // Route to redirect user to on validation failure.
    protected $redirectAction = 'Admin\Settings\SystemSettingController@index';

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
            'db_mysql_host' => 'required',
            'db_mysql_port' => 'required|numeric',
            'db_mysql_database' => 'required',
            'db_mysql_username' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'db_mysql_host.required' => Lang::get('alerts.admin.settings.validation.db_mysql_host_required'),
            'db_mysql_port.required' => Lang::get('alerts.admin.settings.validation.db_mysql_port_required'),
            'db_mysql_port.numeric' => Lang::get('alerts.admin.settings.validation.db_mysql_port_numeric'),
            'db_mysql_database.required' => Lang::get('alerts.admin.settings.validation.db_mysql_database_required'),
            'db_mysql_username.required' => Lang::get('alerts.admin.settings.validation.db_mysql_username_required'),
        ];
    }
}
