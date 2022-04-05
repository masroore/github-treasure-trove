<?php
/*
 * File name: Wallet.php
 * Last modified: 2021.08.10 at 18:04:14
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */

namespace App\Models;

use App\Casts\CurrencyCast;
use App\Traits\Uuids;
use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Class Wallet.
 *
 * @version August 8, 2021, 1:41 pm CEST
 *
 * @property User user
 * @property string name
 * @property string extended_name
 * @property float balance
 * @property Currency currency
 * @property int user_id
 * @property bool enabled
 */
class Wallet extends Model
{
    use Uuids;

    /**
     * Validation rules.
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|max:191',
        'currency' => 'required|exists:currencies,id',
        'user_id' => 'required|exists:users,id',
    ];

    public $table = 'wallets';

    public $fillable = [
        'name',
        'balance',
        'currency',
        'user_id',
        'enabled',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'currency' => CurrencyCast::class,
        'name' => 'string',
        'balance' => 'double',
        'user_id' => 'integer',
        'enabled' => 'boolean',
    ];

    /**
     * New Attributes.
     *
     * @var array
     */
    protected $appends = [
        'custom_fields',
        'extended_name',
    ];

    public function getCustomFieldsAttribute(): array
    {
        $hasCustomField = in_array(static::class, setting('custom_field_models', []));
        if (!$hasCustomField) {
            return [];
        }
        $array = $this->customFieldsValues()
            ->join('custom_fields', 'custom_fields.id', '=', 'custom_field_values.custom_field_id')
            ->where('custom_fields.in_table', '=', true)
            ->get()->toArray();

        return convertToAssoc($array, 'name');
    }

    public function customFieldsValues(): MorphMany
    {
        return $this->morphMany('App\Models\CustomFieldValue', 'customizable');
    }

    public function getExtendedNameAttribute(): string
    {
        return $this->user->name . ' (' . $this->name . ' - ' . $this->balance . ')';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
