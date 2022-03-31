<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\TimeTracking;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyTimeTrackingRequest extends FormRequest  {





public function authorize()
{
    abort_if(Gate::denies('time_tracking_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');




return true;
    
}
public function rules()
{
    



return [
'ids' => 'required|array',
    'ids.*' => 'exists:time_trackings,id',
]
    
}

}