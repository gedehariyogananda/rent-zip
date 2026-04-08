<?php

namespace App\Traits;

trait ApiResponse
{
    protected function apiSuccess($data, $code = 200, $message = null)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function apiError($code, $message = null)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $code);
    }
}
