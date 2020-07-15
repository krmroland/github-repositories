<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\AuthManager;

class DeleteGithubTokenController extends Controller
{
    /**
     * Deletes the existing users github token
     *
     * @param Illuminate\Auth\AuthManager $auth
     *
     * @return Illuminate\Support\Facades\Response
     */
    public function __invoke(AuthManager $auth)
    {
        $auth->user()->update(['github_token' => null]);

        return response()->json('', 204);
    }
}
