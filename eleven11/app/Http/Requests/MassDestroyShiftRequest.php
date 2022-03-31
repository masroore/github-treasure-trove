<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Shift;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyShiftRequest extends FormRequest  {





public function authorize()
{
    abort_if(Gate::denies('shift_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');




return true;
    
}
public function rules()
{
    



return [
'ids' => 'required|array',
    'ids.*' => 'exists:shifts,id',
]
    
}

}