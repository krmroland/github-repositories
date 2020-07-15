<?php

namespace App\Services\GitHub;

use App\Services\GitHub\Contracts\GithubApi;
use Github\Client;

class PhpGithubApi implements GithubApi
{
    /**
     * The github client
     *
     * @var \Github\Client
     */
    protected $client;

    /**
     * Creates an instance of this class
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Authenticates a user using a token
     *
     * @param string $token
     *
     * @return $this
     */
    public function authenticateUsingToken($token)
    {
        $this->client->authenticate($token, Client::AUTH_HTTP_TOKEN);

        return $this;
    }

    /**
     * Gets the current user's started repositories
     *
     * @param array $parameters
     *
     * @return array
     */
    public function getUserStarredRepositories(array $parameters = [])
    {
        return $this->client
            ->api('current_user')
            ->starring()
            ->all($paremeters['page'] ?? 1, $paremeters['per_page'] ?? 30);
    }
}
