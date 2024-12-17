<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class APIController extends Controller
{
    /**
     * Send success JSON response
     *
     * @param mixed $data
     * @param string $message
     * @return JsonResponse
     */
    public function sendResponse(mixed $data = [], string $message = ''): JsonResponse
    {
        $response = [
            'success' => true,
            'data' => $data,
            'message' => $message
        ];

        return response()->json($response, 200);
    }

    /**
     * Send error JSON response
     *
     * @param string $error
     * @param array $errorMessages
     * @param integer $code
     * @return JsonResponse
     */
    public function sendError(string $error, string|array $errorMessages = [], $code = 400, $key = ''): JsonResponse
    {
        // TODO: Store error to log file
        
        $errorMessages = is_array($errorMessages) ? $errorMessages : [$errorMessages];

        $response = [
            'error' => true,
            'message' => $error,
            'data' => $errorMessages,
            'code' => $code,
            'key' => $key,
        ];

        return response()->json($response, $code);
    }
}
