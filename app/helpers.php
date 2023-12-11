<?php

use Illuminate\Http\JsonResponse;

if (! function_exists('json')) {
    function json(array $data, int $statusCode = 200): JsonResponse
    {
        return response()->json($data, $statusCode);
    }
}

if (! function_exists('message')) {
    function message(string $message): JsonResponse
    {
        return json(['message' => $message]);
    }
}
