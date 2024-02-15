<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
        // Handle reportable
        $this->reportable(function (Throwable $e) {
            // Do nothing
        });

        // Custom response when Not Found 404
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                    'error_code' => Response::HTTP_NOT_FOUND,
                    'data' => (object) []
                ], Response::HTTP_NOT_FOUND);
            }
        });

        // Custom response when Unauthenticated 401
        $this->renderable(function (AuthenticationException $e, $request) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                    'error_code' => Response::HTTP_UNAUTHORIZED,
                    'data' => (object) []
                ], Response::HTTP_UNAUTHORIZED);
            }
        });

        // Custom response when Access Forbidden 403
        $this->renderable(function (AccessDeniedHttpException $e, $request) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                    'error_code' => Response::HTTP_FORBIDDEN,
                    'data' => (object) []
                ], Response::HTTP_FORBIDDEN);
            }
        });

        // Custom response when Internal Server Error 500
        $this->renderable(function (Throwable $e, $request) {
            if ($request->wantsJson() && (in_array($e->getCode(), [0, 500]))) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                    'error_code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                    'data' => (object) []
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        });
    }
}
