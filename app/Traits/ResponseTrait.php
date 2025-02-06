<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

trait ResponseTrait
{
    public function sendJsonResponse(
        string $type,
        string $status,
        int $responseCode,
        string $message,
        object $data
    ): JsonResponse {
        return response()->json([
            "time"    => date('Y-m-d H:i:s'),
            "version" => "1.0.0",
            "type"    => $type,
            "status"  => $status,
            "message" => $message,
            "data"    => $data,
        ], $responseCode)
            ->header('Content-Type', 'application/json');
    }

    public function sendErrorResponse(
        int $responseCode,
        string $errorType,
        object $message,
    ): JsonResponse {
        return response()->json([
            "error"   => $errorType,
            "message" => $message,
        ], $responseCode)
            ->header('Content-Type', 'application/json');
    }

    public function formateResponse($collectionData): array
    {
        if (!$collectionData) {
            return [];
        }

        $data = $collectionData->reduce(function ($carry, $item) {
            return $carry->merge($item);
        }, new Collection())->toArray();

        return $data;
    }

}
