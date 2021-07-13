<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt
     */
    public function authenticateAdmin(Request $request)
    {

        try {

            $credentials = $request->validate(
                [
                    'email' => ['required', 'email'],
                    'password' => ['required'],
                ]
            );

            $user = User::where('email', $credentials['email'])->firstOrFail();

            if (Hash::check($credentials['password'], $user->password)) {

                $request->session()->regenerate();
                return response()->json($user, 200);
            }

            return back()->withErrors([
                'error' => 'The provided credentials do not match our records.',
            ]);

        } catch (\Exception$e) {
            return response()->json(['error' => 'user not found!'], 404);
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
                $request->session()->regenerate();
                return response()->json(['data' => [
                    'name' => $employe->name,
                    'store' => $store->name,
                ]], 200);
            }

            return back()->withErrors([
                'error' => 'The provided credentials do not match our records.',
            ]);

        } catch (\Exception$e) {
            return response()->json(['error' => 'user not found!'], 404);
        }

    }

}
