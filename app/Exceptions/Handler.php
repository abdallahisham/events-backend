<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
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
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response|JsonResponse
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            if ($request->wantsJson()) {
                return new JsonResponse([
                    'response' => [
                        'httpCode' => 404,
                        'message' => 'Record not found'
                    ],
                ]);
            }
        }

        if ($exception instanceof NotFoundHttpException) {
            if ($request->wantsJson()) {
                return new JsonResponse([
                    'response' => [
                        'httpCode' => 404,
                        'message' => 'Url not found on server'
                    ],
                ]);
            }
        }

        if ($exception instanceof AuthenticationException) {
            if ($request->wantsJson()) {
                return new JsonResponse([
                    'response' => [
                        'httpCode' => 401,
                        'message' => 'You are not authenticated!'
                    ],
                ]);
            }
        }

        return parent::render($request, $exception);
    }
}
