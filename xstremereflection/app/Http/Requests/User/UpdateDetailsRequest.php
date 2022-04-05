<?php

namespace Vanguard\Http\Requests\User;

use Vanguard\Http\Requests\Request;

class UpdateDetailsRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'birthday' => 'nullable|date',
            'role_id' => 'required|exists:roles,id',
        ];
    }
}
