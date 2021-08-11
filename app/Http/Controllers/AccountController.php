<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountRegisterRequest as RegisterRequest;
use App\Services\ApiResponse\ApiResponseErrorService;
use App\Services\ApiResponse\ApiResponseService;
use App\Services\AuthenticateService;
use App\Services\RegisterAccountService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    /**
     * Update account
     *
     * @param Request $request
     * @return void
     */
    public function update(Request $request)
    {
        try {

           
           
            $this->authorize('update_account');

            $validated = $request->validate(
                ['slug' => ['nullable', 'string']]
            );

            $account = Auth::user()->account;

            $account->update($validated);

            return ApiResponseService::make('Dados alterados com sucesso!!!', 200, $validated);
        } catch (Exception $e) {

            return ApiResponseErrorService::make($e);

        }
    }

    /**
     * Update account
     *
     * @param Request $request
     * @return void
     */
    public function show()
    {
        try {

            $this->authorize('show_account');

            $account = Auth::user()->account->with('stores', 'employees')->first();

            return ApiResponseService::make('Consulta Realizada co  sucesso!!!', 200, $account->toArray());

        } catch (Exception $e) {

            return ApiResponseErrorService::make($e);

        }
    }

}
