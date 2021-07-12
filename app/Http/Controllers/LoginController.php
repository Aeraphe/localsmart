<?php

namespace App\Http\Controllers;

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
                'email' => 'The provided credentials do not match our records.',
            ]);

        } catch (\Exception$e) {
            return response()->json(['message' => 'user not found!'], 404);
        }

    }

}
