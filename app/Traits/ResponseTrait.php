<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ResponseTrait
{
    /**
     * @param $data
     * @param $message
     * @param int $status
     * @return JsonResponse
     */
    protected function successResponse(
        $data = null,
        $message = null,
        int $status = 200): JsonResponse {

        return response()->json([
            'success'   => true,
            'data'      => $data,
            'message'   => $message
        ], $status)->setEncodingOptions(JSON_UNESCAPED_SLASHES);
    }

    /**
     * @param $message
     * @param int $status
     * @param $data
     * @return JsonResponse
     */
    protected function errorResponse(
        string $message = "error",
        int    $status = 400,
               $data = null): JsonResponse {

        return response()->json([
            'error'     => true,
            'message'   => $message,
            'data'      => $data
        ], $status)->setEncodingOptions(JSON_UNESCAPED_SLASHES);
    }
}
