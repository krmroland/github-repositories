<?php

namespace App\Services\GitHub\Contracts;

interface GithubApi
{
    /**
     * Gets the started repositories
     *
     * @param array $parameters
     *
     * @return array
     */
    public function getUserStarredRepositories(array $parameters = []);

    /**
     * Authenticates a user using a token
     *
     * @param string $token
     *
     * @return $this
     */
    public function authenticateUsingToken($token);
}
