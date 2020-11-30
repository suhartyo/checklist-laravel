<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Validation\UnauthorizedException;
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

    public function render($request, Throwable $e)
    {
        // Better if we create our exception. More easier to handle
        if ($request->wantsJson()) {
            if ($e instanceof ModelNotFoundException) {
                return response()->json([
                    'status' => (string) Response::HTTP_NOT_FOUND,
                    'error' => 'Not Found'
                ], Response::HTTP_NOT_FOUND);
            } elseif (method_exists($e, 'getStatusCode')) {
                return response()->json([
                    'status' => (string) $e->getStatusCode(),
                    'error' => $e->getMessage(),
                ], $e->getStatusCode());
            } elseif ($e instanceof UnauthorizedException) {
                return response()->json([
                    'status' => (string) Response::HTTP_UNAUTHORIZED,
                    'error' => 'Not Authorized',
                ], Response::HTTP_UNAUTHORIZED);
            } elseif ($e instanceof \ParseError) {
                return response()->json([
                    'status' => (string) Response::HTTP_INTERNAL_SERVER_ERROR,
                    'error' => 'Server Error',
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }

        return parent::render($request, $e); // TODO: Change the autogenerated stub
    }
}
