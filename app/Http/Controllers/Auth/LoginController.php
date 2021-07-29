<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminAuthRequest;
use App\Http\Requests\Employee\EmployeAuthRequest;
use App\Services\ApiResponse\ApiResponseErrorService as ErrorResponse;
use App\Services\ApiResponse\ApiResponseService as ApiResponse;
use App\Services\AuthenticateService as AuthService;
use Exception;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    /**
     * Handle an authentication attempt
     */
    public function authenticateAccountUserApi(AdminAuthRequest $request)
    {

        try {

            $credentials = $request->validated();
            $authenticateUser = AuthService::athenticateAccountUser($credentials);
            $data = ['name' => $authenticateUser->name, 'access_token' => $authenticateUser->token()];
            
            return ApiResponse::make('Login realizado com sucesso', 200, $data);

        } catch (Exception $e) {

            return ErrorResponse::make($e);

        }

    }

    /**
     * Handle an authentication attempt for web routes, with session
     */
    public function authenticateAccountUserWeb(AdminAuthRequest $request)
    {

        try {

            $credentials = $request->validated();
            $authenticateUser = AuthService::athenticateAccountUser($credentials);

            if ($authenticateUser) {
                Auth::login($authenticateUser);
                $request->session()->regenerate();
                return response()->json(['data' => ['name' => $authenticateUser->name]], 200);
            }

            return back()->withErrors([
                'error' => 'The provided credentials do not match our records.',
            ]);

        } catch (\Exception$e) {
            return response()->json(['error' => 'user not found!', 'message' => $e->getMessage()], 404);
        }

    }

    /**
     * Authenticate Store employes
     *
     * @param EmployeAuthRequest $request
     * @return Response
     */
    public function authenticateEmployeApi(EmployeAuthRequest $request)
    {
        try {

            $credentials = $request->validated();
            $accountSlug = $request->route('account');
            $storeSlug = $request->route('store');

            $employe = AuthService::authenticateEmployeUser($credentials, $accountSlug, $storeSlug);

            if ($employe) {
                $token = $employe->createToken('maria dalva de castro oliveira')->accessToken;
                return response()->json(['data' => [
                    'name' => $employe->name,
                    'access_token' => $token,
                    'store' => $employe->stores->firstWhere('slug', $storeSlug)->name,

                ]], 200);
            }

            return back()->withErrors([
                'error' => 'The provided credentials do not match our records.',
            ]);

        } catch (\Exception$e) {
            return response()->json(['error' => 'user not found!', 'message' => $e->getMessage()], 404);
        }

    }

    /**
     * Authenticate Store employes
     *
     * @param EmployeAuthRequest $request
     * @return Response
     */
    public function authenticateEmployeWeb(EmployeAuthRequest $request)
    {
        try {

            $credentials = $request->validated();
            $accountSlug = $request->route('account');
            $storeSlug = $request->route('store');

            $employe = AuthService::authenticateEmployeUser($credentials, $accountSlug, $storeSlug);

            if ($employe) {
                Auth::login($employe);
                $request->session()->regenerate();
                return response()->json(['data' => [
                    'name' => $employe->name,
                    'store' => $employe->stores->firstWhere('slug', $storeSlug)->name,

                ]], 200);
            }

            return back()->withErrors([
                'error' => 'The provided credentials do not match our records.',
            ]);

        } catch (\Exception$e) {
            return response()->json(['error' => 'user not found!', 'message' => $e->getMessage()], 404);
        }

    }

}
