<?php

namespace Modules\List\app\Http\Traits;

trait ApiResponse
{
    protected function successResponse($data = null, string $message = null, int $status = 200)
    {
        return response()->json($data, $status);
    }

    protected function errorResponse(string $message, int $status = 400, array $errors = [])
    {
        $payload = [
            'message' => $message,
        ];

        if (!empty($errors)) {
            $payload['errors'] = $errors;
        }

        return response()->json($payload, $status);
    }
}
