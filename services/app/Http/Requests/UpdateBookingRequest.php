<?php
/*
 * File name: UpdateBookingRequest.php
 * Last modified: 2021.01.29 at 23:27:25
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class UpdateBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'address_id' => 'required|exists:addresses,id',
            'payment_status_id' => 'nullable|exists:payment_statuses,id',
            'booking_status_id' => 'required|exists:booking_statuses,id',
            'booking_at' => 'required',
        ];
    }

    /**
     * @param null|array|mixed $keys
     */
    public function all($keys = null): array
    {
        $array = parent::all();

        return Arr::only($array, [
            'address_id',
            'payment_status_id',
            'booking_status_id',
            'booking_at',
            'start_at',
            'ends_at',
            'hint',
            'cancel',
        ]);
    }
}
