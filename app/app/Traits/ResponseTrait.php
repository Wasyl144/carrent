<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ResponseTrait
{
    public function responseSuccess(?array $data, int $status = Response::HTTP_OK): JsonResponse
    {
        return response()->json(['data' => $data, 'success' => true], $status)->header('Content-Type', 'application/json');
    }

    public function responseFailed(?string $errorMessage, int $status = Response::HTTP_NOT_FOUND): JsonResponse
    {
        return response()->json(['error' => $errorMessage, 'error_code' => $status, 'success' => true], $status)->header('Content-Type', 'application/json');
    }
}
