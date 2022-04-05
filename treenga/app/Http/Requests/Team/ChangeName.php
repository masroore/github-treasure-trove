<?php

namespace App\Http\Requests\Team;

use App\Http\Requests\ApiRequest;
use Illuminate\Validation\Rule;

class ChangeName extends ApiRequest
{
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
        $teamId = $this->team->id;
        $userId = auth()->id();

        return [
            'username' => ['required', 'max:64', Rule::unique('team_user')->where(function ($q) use ($teamId, $userId): void {
                $q->where('team_id', $teamId)->where('user_id', '<>', $userId);
            })],
        ];
    }
}
