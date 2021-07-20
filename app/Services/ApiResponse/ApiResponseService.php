<?php

namespace App\Services\ApiResponse;

use Illuminate\Http\Response;

class ApiResponseService
{

    public static function make(string $message, int $code, array $data, array $headers = [])
    {

        $responseData = [
            'data' => $data,
            '_message' => $message,
            '_status' => $code,
            '_url' => request()->url(),
            '_method' => request()->method(),
        ];

        return new Response($responseData, $code, $headers);
    }
}
