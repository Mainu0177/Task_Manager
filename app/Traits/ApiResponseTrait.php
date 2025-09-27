<?php

namespace App\Traits;

trait ApiResponseTrait
{
    protected function success(mixed $data = null, string $message = '', int $code = 200){
        return response()->json([
            'status' => true,
            'data' => $data,
            'message' => $message,
        ], $code);
    }

    protected function error(array $message = ['Internal Server Error'], int $code = 500){
        return response()->json([
            'status' => false,
            'message' => $message,
        ], $code);
    }
}
