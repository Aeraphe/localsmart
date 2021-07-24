<?php

namespace App\Services\ApiResponse;

use Illuminate\Http\Response;

class ApiResponseErrorService
{

    /**
     * Create Reponse Exception
     *
     * @param [Exception] $exception
     *
     * @return Illuminate\Http\Response
     */
    public static function make($exception)
    {

        $status = $exception->getCode() == 0 ? 500 : $exception->getCode();

        $responseData = [
            'errors' => self::exceptionErrorHandle($exception),
            '_message' => self::exceptionMessageHandle($exception),
            '_status' => $status,
            '_url' => request()->url(),
            '_method' => request()->method(),
        ];

        return new Response($responseData, $status);
    }

    /**
     * Handle for get Exception Errors
     *
     * @param [Exception] $exception
     * @return array | string
     */
    private static function exceptionErrorHandle($exception)
    {

        if (!method_exists($exception, 'getData')) {

            return ['internal' => $exception->getMessage()];

        } else {

            return $exception->getData();

        }

    }

    /**
     * Handle Exception Messages
     *
     * @param [Exception] $exception
     * @return [string] $message
     */
    private static function exceptionMessageHandle($exception)
    {

        switch ($exception::class) {

            case 'App\Exceptions\BaseException':

                $message = $exception->getMessage();
                break;

            case 'App\Exceptions\RegisterEmployeeLoginException':

                $message = "Nome para login já cadastrado";
                break;

            case 'Illuminate\Auth\Access\AuthorizationException':

                $message = 'Operação não autorizada, entre em contato com o administrador do sistema';
                break;

            default:
                $message = $exception->getMessage();
                break;
        }
        return $message;
    }

}
