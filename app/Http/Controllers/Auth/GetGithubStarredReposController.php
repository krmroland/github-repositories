<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;

class GetGithubStarredReposController extends Controller
{
    /**
     * The request class
     *
     * @var Illuminate\Http\Request
     */
    protected $request;

    /**
     * The AuthManager class
     *
     * @var Illuminate\Auth\AuthManager
     */
    protected $auth;

    /**
     * Creates an instance of the controller
     *
     * @param Illuminate\Http\Request $request
     * @param Illuminate\Auth\AuthManager $auth
     */
    public function __construct(Request $request, AuthManager $auth)
    {
        $this->request = $request;

        $this->auth = $auth;
    }

    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        // cache the response for at least a minute
        return cache()->remember($this->dataCacheKey(), 60, function () {
            return response()->json($this->data());
        });
    }

    /**
     * Gets the starred repositories
     *
     * @return array
     */
    protected function data()
    {
        return $this->auth
            ->user()
            ->github()
            ->getUserStarredRepositories($this->queryParameters());
    }

    /**
     * Gets the data cache key
     *
     * @return string
     */
    protected function dataCacheKey()
    {
        return vsprintf('user-stared-repositories-%s-%s-%s', [
            $this->auth->id(),
            // we will burst the cache when the user is updated
            // just for edge cases where they might have nullified the token
            $this->auth->user()->updated_at,

            implode('-', $this->queryParameters()),
        ]);
    }

    /**
     * Gets the query parameters
     *
     * @return array
     */
    protected function queryParameters()
    {
        return $this->request->only('per_page', 'page');
    }
}
