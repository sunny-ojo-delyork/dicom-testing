<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\Response;

trait JsonResponse
{
    public function successResponse(
        $data,
        $message = "Operation Successful",
        $statusCode = Response::HTTP_OK
    ): \Illuminate\Http\JsonResponse
    {
        $response = [
            "success" => true,
            "data" => $data,
            "message" => $message
        ];
        return response()->json($response, $statusCode);
    }

   
    public function errorResponse(
        $data,
        $message = null,
        int $statusCode = Response::HTTP_BAD_REQUEST
    ): \Illuminate\Http\JsonResponse
    {
        $response = ["success" => false, "message" => $message];

        if (! is_null($data)) {
            $response["data"] = $data;
        }
        return response()->json($response, $statusCode);
    }
 }
