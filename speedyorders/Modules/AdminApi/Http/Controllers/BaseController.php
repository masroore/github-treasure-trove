<?php

namespace Modules\AdminApi\Http\Controllers;

use Illuminate\Routing\Controller;

class BaseController extends Controller
{
    public function success($resultArray, $responeCode = 200)
    {
        return response()->json([
            'status'=>true,
            'data'=>$resultArray,
        ], $responeCode);
    }

    public function failure($message, $responeCode = 200)
    {
        return response()->json([
            'status'=>false,
            'data'=>[
                'message'=>$message,
            ],
        ], $responeCode);
    }
}
