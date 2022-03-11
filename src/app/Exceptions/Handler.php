<?php

namespace App\Exceptions;

use Exception;
use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }


    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Throwable $exception
     * @return bool|\Symfony\Component\HttpFoundation\Response
     * @throws Throwable
     */
    public function render($request, \Throwable $exception)
    {
        if($exception instanceof ModelNotFoundException || $exception instanceof NotFoundHttpException) {
            return $this->NotFoundExceptionMessage($request, $exception);
        }
        return parent::render($request, $exception);
    }

    /**
     * @param $request
     * @param Exception $exception
     * @return JsonResponse|\Symfony\Component\HttpFoundation\Response
     * @throws Throwable
     */
    public function NotFoundExceptionMessage($request, Exception $exception)
    {
        return $request->expectsJson()
            ? response()->json(['Not Found'] , 404)
            : parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into a response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param AuthenticationException $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $request->expectsJson()
            ? response()->json(['Forbidden Access'] , 401)
            : redirect()->guest(route('login'));
    }

    protected function invalidJson($request, ValidationException $exception)
    {
        return response()->json( $exception->errors() ,  $exception->status);
    }
}
