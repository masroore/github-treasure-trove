<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Throwable;

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
     */
    public function report(Throwable $exception): void
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Throwable $exception)
    {
        if ($request->wantsJson()) {
            if ($exception instanceof ThrottleRequestsException) {
                return response()->json(['message' => $exception->getMessage()], Response::HTTP_TOO_MANY_REQUESTS);
            }
            if ($exception instanceof ModelNotFoundException) {
                return response()->json(['message' => $exception->getMessage()], Response::HTTP_NOT_FOUND);
            }

            if ($exception instanceof ValidationException) {
                return response()->json(['message' => trans('validation.message'), 'errors' => $exception->validator->getMessageBag()], 422);
            } //type your error code.
        }

        return parent::render($request, $exception);
    }
}
