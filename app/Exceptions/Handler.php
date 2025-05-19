<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types that are not reported.
     *
     * @var array<class-string<Throwable>>
     */
    protected array $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int,string>
     */
    protected array $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        //
    }

    /**
     * Customize the JSON response for validation errors.
     */
    protected function invalidJson($request, ValidationException $exception)
    {
        return response()->json([
            'message' => 'The given data was invalid.',
            'errors'  => $exception->errors(),
        ], $exception->status);
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $e)
    {
        // Only apply for API routes
        if ($request->is('api/*')) {
            // Validation errors (422)
            if ($e instanceof ValidationException) {
                return $this->invalidJson($request, $e);
            }

            // Missing Eloquent model (404)
            if ($e instanceof ModelNotFoundException) {
                $model = class_basename($e->getModel());
                return response()->json([
                    'message' => "{$model} not found",
                ], 404);
            }

            // 404: either missing model or bad endpoint
            if ($e instanceof NotFoundHttpException) {
                $prev = $e->getPrevious();
                if ($prev instanceof ModelNotFoundException) {
                    $model = class_basename($prev->getModel());
                    return response()->json([
                        'message' => "{$model} not found",
                    ], 404);
                }
                return response()->json([
                    'message' => 'Endpoint not found',
                ], 404);
            }

            // Wrong HTTP verb (405)
            if ($e instanceof MethodNotAllowedHttpException) {
                return response()->json([
                    'message' => 'Method Not Allowed',
                ], 405);
            }

            // Fallback for all other exceptions (500 or provided status)
            $status = $e instanceof HttpExceptionInterface
                ? $e->getStatusCode()
                : 500;

            return response()->json([
                'message' => $e->getMessage() ?: 'Server Error',
            ], $status);
        }

        // Non-API requests fall back to the default HTML error pages
        return parent::render($request, $e);
    }
}
