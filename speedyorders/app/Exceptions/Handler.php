<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [

    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @throws Exception
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Exception $exception)
    {
        if ($request->wantsJson()) {   //add Accept: application/json in request
            return $this->handleApiException($request, $exception);
        }

        // custom error message
        if ($exception instanceof \ErrorException) {
            $message = $exception->getMessage();

            return redirect()->route('errors');
        }

        return parent::render($request, $exception);

        return parent::render($request, $exception);
    }

    private function handleApiException($request, Exception $exception)
    {
        // jwt exception
        if ($exception instanceof UnauthorizedHttpException) {
            $preException = $exception->getPrevious();
            if ($preException instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['error' => 'TOKEN_EXPIRED']);
            }
            if ($preException instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['error' => 'TOKEN_INVALID']);
            }
            if ($preException instanceof \Tymon\JWTAuth\Exceptions\TokenBlacklistedException) {
                return response()->json(['error' => 'TOKEN_BLACKLISTED']);
            }
            if ('Token not provided' === $exception->getMessage()) {
                return response()->json(['error' => 'Token not provided']);
            }
        }

        // other exception
        $exception = $this->prepareException($exception);

        if ($exception instanceof \Illuminate\Http\Exception\HttpResponseException) {
            $exception = $exception->getResponse();
        }
        if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
            $exception = $this->unauthenticated($request, $exception);
        }
        if ($exception instanceof \Illuminate\Validation\ValidationException) {
            $exception = $this->convertValidationExceptionToResponse($exception, $request);
        }
        if ($exception instanceof \Illuminate\Database\QueryException) {
            if (config('app.debug')) {
                $error = $exception->errorInfo;
                $statusCode = 422;
                $response['success'] = false;
                $response['data']['error'] = $error;

                return response()->json($response, $statusCode);
            }
        }

        return $this->customApiResponse($exception);
    }

    private function customApiResponse($exception)
    {
        if (method_exists($exception, 'getStatusCode')) {
            $statusCode = $exception->getStatusCode();
        } else {
            $statusCode = 500;
        }

        $response = [];

        switch ($statusCode) {
            case 401:
                $error = 'Unauthorized';
                break;
            case 403:
                $error = 'Forbidden';
                break;
            case 404:
                $error = 'Not Found';
                break;
            case 405:
                $error = 'Method Not Allowed';
                break;
            case 422:
                $error = $exception->original['message'];
                break;
            default:
                $error = (500 == $statusCode) ? 'Whoops, looks like something went wrong' : $exception->getMessage();
                break;
        }

        $response['success'] = false;

        $response['data']['error'] = $error;

        return response()->json($response, $statusCode);
    }
}
