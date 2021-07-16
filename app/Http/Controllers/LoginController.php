<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminAuthRequest;
use App\Models\Account;
use App\Models\Staff;
use App\Services\AuthenticateService as AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

            if ($authenticateUser) {
                $token = $authenticateUser->createToken('maria dalva de castro oliveira')->accessToken;
                return response()->json(['data' => ['name' => $authenticateUser->name, 'access_token' => $token]], 200);
            }

            return back()->withErrors([
                'error' => 'The provided credentials do not match our records.',
            ]);

        } catch (\Exception$e) {
            return response()->json(['error' => 'user not found!', 'message' => $e->getMessage()], 404);
        }

    }

    public function authenticateEmploye(Request $request)
    {
        try {
            $credentials = $request->validate([
                'login_name' => ['required'],
                'password' => ['required'],
            ]);

            $accountSlug = $request->route('account');
            $storeSlug = $request->route('store');

            $account = Account::where('slug', $accountSlug)->firstOrFail();

            $employeQuery = [['login_name', '=', $credentials['login_name']], ['account_id', '=', $account->id]];
            $employe = Staff::where($employeQuery)->firstOrFail();

            $stores = $employe->stores;

            $store = $stores->firstWhere('slug', $storeSlug);

            if (Hash::check($credentials['password'], $employe->password) && $store->status) {

                $token = $employe->createToken('maria dalva de castro oliveira')->accessToken;
                return response()->json(['data' => [
                    'name' => $employe->name,
                    'store' => $store->name,
                    'access_token' => $token,

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
