<?php

namespace App\Traits;

trait ResponseTrait
{
    public function responseSuccess(?array $data, int $status = 200)
    {
        return response()->json(['data' => $data, 'success' => true], $status);
    }

    public function responseFailed(?array $data, int $status = 404)
    {
        return response()->json(['data' => $data, 'success' => false], $status);
    }
}
