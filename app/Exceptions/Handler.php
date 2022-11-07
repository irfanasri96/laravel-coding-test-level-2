<?php

namespace App\Exceptions;

use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Laravel\Passport\Exceptions\MissingScopeException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;

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

    // public function render($request, Throwable $exception)
    // {
    //     if ($exception instanceof MissingScopeException) {
    //         $http_response = 403;
    //         $message = [
    //             'errors' => ['User do not have access'],
    //         ];
    //         return response()->json($message, $http_response);
    //     } elseif ($exception instanceof ValidationException) {
    //         $http_response = 422;
    //         $message = [
    //             'errors' => $exception->errors(),
    //         ];
    //         return response()->json($message, $http_response);
    //     } elseif ($exception instanceof RouteNotFoundException) {
    //         $http_response = 404;
    //         $message = [
    //             'errors' => ['Route not found'],
    //         ];
    //         return response()->json($message, $http_response);
    //     } elseif ($exception instanceof AuthenticationException) {
    //         $http_response = 401;
    //         $message = [
    //             'errors' => ['Unauthenticated.'],
    //         ];
    //         return response()->json($message, $http_response);
    //     } elseif ($exception instanceof ModelNotFoundException) {
    //         $http_response = 404;
    //         $message = [
    //             'errors' => ['Model not found'],
    //         ];
    //         return response()->json($message, $http_response);
    //     } elseif ($exception instanceof QueryException) {
    //         $http_response = 400;
    //         $message = [
    //             'errors' => ['Bad request'],
    //         ];
    //         return response()->json($message, $http_response);
    //     } elseif ($exception instanceof Throwable) {
    //         $http_response = 500;
    //         $message = [
    //             'errors' => ['Internal server error'],
    //         ];
    //         return response()->json($message, $http_response);
    //     }

    //     return parent::render($request, $exception);
    // }
}
