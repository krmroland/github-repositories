<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Auth\AuthManager $auth
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, AuthManager $auth)
    {
        // todo: Throttle logins?

        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required|min:6',
        ]);

        if ($auth->attempt($credentials, $request->filled('remember_me'))) {
            $request->session()->regenerate();

            return response()->json([
                'message' => 'User was authenticated successfully',
                'user' => $auth->user(),
            ]);
        }

        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')],
        ]);
    }
}
