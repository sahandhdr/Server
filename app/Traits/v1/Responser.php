<?php

namespace App\Traits\v1;

use Illuminate\Http\JsonResponse;

trait Responser
{
    protected function apiResponse(
        bool $success = true,
        string $message = null,
        mixed $data = null,
        int $status = 200,
        array $extra = null
    ): JsonResponse {
        $response = [
            'status' => $success ? 'success' : 'error',
            'message' => $message,
        ];

        if (!is_null($data)) {
            $response['data'] = $data;
        }

        if (!is_null($extra)) {
            $response = array_merge($response, $extra);
        }

        return response()->json($response, $status);
    }
}
