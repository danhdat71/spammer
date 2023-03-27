<?php

namespace App\Traits;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

trait ResponseTrait
{    
    /**
     * responseSuccess
     *
     * @param  mixed $data
     * @return JsonResponse
     */
    public function responseSuccess($data): JsonResponse
    {
        return response()->json([
            'status' => true,
            'data' => $data,
        ], Response::HTTP_OK);
    }

    /**
     * messageSuccess
     *
     * @param  mixed $messages
     * @return JsonResponse
     */
    public function messageSuccess($messages): JsonResponse
    {
        return response()->json([
            'status' => true,
            'messages' => $messages,
        ], Response::HTTP_OK);
    }

    /**
     * responseFail
     *
     * @param  mixed $messages
     * @return JsonResponse
     */
    public function responseFail($messages): JsonResponse
    {
        return response()->json([
            'status' => false,
            'messages' => $messages,
        ], Response::HTTP_OK);
    }
}
