<?php

namespace Modules\Authorization\app\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

trait ApiResponseTrait
{
    /**
     * Return a success response
     */
    protected function successResponse(
        mixed $data = null,
        string $message = 'Success',
        int $statusCode = 200,
        array $meta = []
    ): JsonResponse {
        $response = [
            'success' => true,
            'message' => $message,
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }

        if (!empty($meta)) {
            $response['meta'] = array_merge([
                'timestamp' => now()->toISOString(),
            ], $meta);
        } else {
            $response['meta'] = [
                'timestamp' => now()->toISOString(),
            ];
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Return an error response
     */
    protected function errorResponse(
        string $message = 'Error',
        int $statusCode = 400,
        mixed $errors = null,
        array $meta = []
    ): JsonResponse {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if ($errors !== null) {
            $response['errors'] = $errors;
        }

        if (!empty($meta)) {
            $response['meta'] = array_merge([
                'timestamp' => now()->toISOString(),
            ], $meta);
        } else {
            $response['meta'] = [
                'timestamp' => now()->toISOString(),
            ];
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Return a paginated response
     */
    protected function paginatedResponse(
        ResourceCollection $collection,
        string $message = 'Success'
    ): JsonResponse {
        $paginator = $collection->resource;
        
        return $this->successResponse(
            $collection->items(),
            $message,
            200,
            [
                'pagination' => [
                    'current_page' => $paginator->currentPage(),
                    'last_page' => $paginator->lastPage(),
                    'per_page' => $paginator->perPage(),
                    'total' => $paginator->total(),
                    'from' => $paginator->firstItem(),
                    'to' => $paginator->lastItem(),
                    'has_more_pages' => $paginator->hasMorePages(),
                ],
            ]
        );
    }

    /**
     * Return a resource response
     */
    protected function resourceResponse(
        JsonResource $resource,
        string $message = 'Success',
        int $statusCode = 200
    ): JsonResponse {
        return $this->successResponse(
            $resource,
            $message,
            $statusCode
        );
    }

    /**
     * Return a validation error response
     */
    protected function validationErrorResponse(array $errors): JsonResponse
    {
        return $this->errorResponse(
            'Validation failed',
            422,
            $errors
        );
    }

    /**
     * Return an unauthorized response
     */
    protected function unauthorizedResponse(string $message = 'Unauthorized'): JsonResponse
    {
        return $this->errorResponse($message, 401);
    }

    /**
     * Return a forbidden response
     */
    protected function forbiddenResponse(string $message = 'Forbidden'): JsonResponse
    {
        return $this->errorResponse($message, 403);
    }

    /**
     * Return a not found response
     */
    protected function notFoundResponse(string $message = 'Resource not found'): JsonResponse
    {
        return $this->errorResponse($message, 404);
    }

    /**
     * Return a server error response
     */
    protected function serverErrorResponse(string $message = 'Internal server error'): JsonResponse
    {
        return $this->errorResponse($message, 500);
    }
}