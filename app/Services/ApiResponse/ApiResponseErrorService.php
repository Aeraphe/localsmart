<?php

namespace App\Services\ApiResponse;

use Illuminate\Http\Response;

class ApiResponseErrorService
{

    public static function make($exception)
    {

        if (!method_exists($exception, 'getData')) {
            $error =  ['internal' => $exception->getMessage()];
            $message = 'Erro inesperado. Favor entrar em contato com o responsável pelo aplicativo';
            $status = 500;
        } else {
            $error = $exception->getData();
            $message = $exception->getMessage();
            $status = $exception->getCode() == 0 ? 500 : $exception->getCode();
        }

        $responseData = [
            'errors' => $error,
            '_message' => $message,
            '_status' => $status,
            '_url' => request()->url(),
            '_method' => request()->method(),
        ];

        return new Response($responseData, 200);
    }
}
