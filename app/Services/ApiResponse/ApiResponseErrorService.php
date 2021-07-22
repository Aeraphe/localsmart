<?php

namespace App\Services\ApiResponse;


use Illuminate\Http\Response;

class ApiResponseErrorService
{

    public static function make($exception)
    {

        if (!method_exists($exception, 'getData')) {
            $error = ['error' => $exception->getMessage()];
            $message = 'Erro inesperado. Favor entrar em contato com o responsável pelo aplicativo';
            $status = 500;
        } else {
            $error = ['error' => $exception->getData()];
            $message = $exception->getMessage();
            $status = $exception->getCode();
        }

        $responseData = [
            'error' => $error,
            '_message' => $message,
            '_status' => $status,
            '_url' => request()->url(),
            '_method' => request()->method(),
        ];

        return new Response($responseData, $exception->getCode());
    }
}
