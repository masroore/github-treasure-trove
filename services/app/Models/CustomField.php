<?php
/**
 * File name: CustomField.php
 * Last modified: 2019.08.27 at 15:37:12
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021.
 */

namespace App\Models;

use Eloquent as Model;

/**
 * Class CustomField.
 *
 * @version July 24, 2018, 9:13 pm UTC
 *
 * @property string name
 * @property string type
 * @property bool disabled
 * @property bool required
 * @property bool in_table
 * @property tinyInteger bootstrap_column
 * @property tinyInteger order
 * @property string custom_field_model
 */
class CustomField extends Model
{
    public $table = 'custom_fields';

    public $fillable = [
        'name',
        'type',
        'values',
        'disabled',
        'required',
        'in_table',
        'bootstrap_column',
        'order',
        'custom_field_model',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'type' => 'string',
        'values' => 'array',
        'disabled' => 'boolean',
        'required' => 'boolean',
        'in_table' => 'boolean',
        'custom_field_model' => 'string',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'type' => 'required',
        'bootstrap_column' => 'min:1|max:12',
        'custom_field_model' => 'required',
    ];

    /**
     * New Attributes.
     *
     * @var array
     */
    protected $appends = [

    ];
}
