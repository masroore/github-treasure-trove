<?php

namespace App\Traits;

/*
|--------------------------------------------------------------------------
| Api Responser Trait
|--------------------------------------------------------------------------
|
| This trait will be used for any response we sent to clients.
|
*/

trait ApiResponser
{
    /**
     * Return a success JSON response.
     *
     * @param array|string $data
     * @param string       $message
     * @param null|int     $code
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function success($data, ?string $message = null, int $code = 200)
    {
        return response()->json([
            'is_success' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    /**
     * Return an error JSON response.
     *
     * @param string            $message
     * @param null|array|string $data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function error(?string $message, int $code, $data = null)
    {
        return response()->json([
            'is_success' => false,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}
