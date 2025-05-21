<?php

namespace Modules\SearchAndFiltering\app\Traits;

trait ApiResponse
{
    /**
     * Return only the data payload (no wrapper) on success.
     *
     * Controllers still call:
     *     $this->successResponse($data, $message?, $status?);
     *
     * but only the $data is JSON-encoded here.
     */
    protected function successResponse($data = null, string $message = null, int $status = 200)
    {
        return response()->json($data, $status);
    }

    /**
     * Return a JSON error with only a message (and optional errors array).
     *
     * Controllers call:
     *     $this->errorResponse('Something went wrong', 422, $validationErrors);
     */
    protected function errorResponse(string $message, int $status = 400, array $errors = [])
    {
        $payload = [
            'message' => $message,
        ];

        if (! empty($errors)) {
            $payload['errors'] = $errors;
        }

        return response()->json($payload, $status);
    }
}
