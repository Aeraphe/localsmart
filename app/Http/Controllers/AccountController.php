<?php

namespace App\Http\Controllers;

use App\Exceptions\BaseException;
use App\Http\Requests\AccountRegisterRequest as RegisterRequest;
use App\Services\ApiResponse\ApiResponseErrorService;
use App\Services\ApiResponse\ApiResponseService;
use App\Services\AuthenticateService;
use App\Services\RegisterAccountService;
use Exception;

class AccountController extends Controller
{
    public function create(RegisterRequest $request)
    {

        try {

            $credentials = $request->validated();

            RegisterAccountService::create($credentials);
            //Authenticate the new user
            $authenticateUser = AuthenticateService::athenticateAccountUser(['email' => $credentials['email'], 'password' => $credentials['password']]);

            $responseData = [
                'name' => $authenticateUser->name,
                'access_token' => $authenticateUser->token(),
            ];

            return ApiResponseService::make('Conta criada com sucesso', 200, $responseData);

        } catch (Exception $e) {

            return ApiResponseErrorService::make($e);

        }

    }
}
