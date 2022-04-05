<?php

namespace App\Http\Requests\Front;

use App\Http\Requests\BaseFormRequest;

class FormsRequest extends BaseFormRequest
{
    public $formTypes = [
        'contacts',
        'subscribers',
        'request',
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];
        switch ($this->request->get('type')) {
            case 'subscribers':
                $rules = [
                    'email' => 'required|email|max:50',
                    'subscribe' => 'nullable|in:0,1',
                    'accept' => 'required|accepted',
                ];

                break;
            case 'contacts':
                $rules = [
                    'name' => 'required|string|max:191',
                    'phone' => 'string|max:20',
                    'email' => 'email|max:50',
                    'message' => 'required|string|max:2048',
                    'accept' => 'required|accepted',
                ];

                break;
            case 'request':
                $rules = [
                    'name' => 'required|string|max:191',
                    'phone' => 'required|string|max:20',
                    'address' => 'nullable|string|max:200',
                    'email' => 'nullable|email|max:50',
                    'message' => 'required|string|max:2048',
                    'accept' => 'sometimes|required|accepted',
                    'subscribe' => 'nullable|boolean',
                    'terms.*' => 'array|max:1',
                    'terms.*.*' => 'numeric|exists:terms,id',
                ];

                break;
        }

        return array_merge([
            'type' => 'required|in:' . implode(',', $this->formTypes),
            'locale' => 'sometimes|required',
        ], $rules);
    }

    public function messages()
    {
        return [
            'accept.accepted' => 'Для продолжения, Вы должны согласится с условиями',
        ];
    }
}
