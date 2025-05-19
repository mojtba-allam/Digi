<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Validation errors → 422 + { message, errors }
        $exceptions->renderable(function (ValidationException $e, $request) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors'  => $e->errors(),
            ], 422);
        });

        // Missing model → 404 + { message: "<Model> not found" }
        $exceptions->renderable(function (ModelNotFoundException $e, $request) {
            $model = class_basename($e->getModel());
            return response()->json([
                'message' => "$model not found",
            ], 404);
        });

        // Bad endpoint → 404 + { message: "Endpoint not found" }
        $exceptions->renderable(function (NotFoundHttpException $e, $request) {
            return response()->json([
                'message' => 'Endpoint not found',
            ], 404);
        });

        // Wrong verb → 405 + { message: "Method Not Allowed" }
        $exceptions->renderable(function (MethodNotAllowedHttpException $e, $request) {
            return response()->json([
                'message' => 'Method Not Allowed',
            ], 405);
        });

        // Fallback for anything else → use code if available, else 500
        $exceptions->respond(function ($request, Throwable $e) {
            $status = $e instanceof HttpExceptionInterface
                ? $e->getStatusCode()
                : 500;
            return response()->json([
                'message' => $e->getMessage() ?: 'Server Error',
            ], $status);
        });
    })
    ->create();
