<?php

namespace App\Services\ApiResponse;

use Illuminate\Http\Response;

class ApiResponseErrorService
{

    public static function make(\Exception $ex, array $error = null)
    {

       
        $responseData = [
            'error' => $error,
            '_message' => $ex->getMessage(),
            '_status' => $ex->getCode(),
            '_url' => request()->url(),
            '_method' => request()->method(),
        ];

        return new Response($responseData,$ex->getCode());
    }
}
