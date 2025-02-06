<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Register the exception handling callbacks for the application.
     */
    public function render($request, Throwable $exception)
    {

        if ($exception instanceof MethodNotAllowedHttpException) {

            if ($request->ajax() || $request->is('api/*')) {
                return response()->json([
                    'success' => 'failed',
                    'title'   => localize('Method Not Allowed'),
                    'message' => $exception->getMessage(),
                ], 405);
            }

        }

        if ($exception instanceof NotFoundHttpException) {

            if ($request->ajax() || $request->is('api/*')) {
                return response()->json([
                    'success' => 'failed',
                    'title'   => localize('Invalid url'),
                    'message' => $exception->getMessage(),
                ], 404);
            }

        }

        return parent::render($request, $exception);
    }

}
