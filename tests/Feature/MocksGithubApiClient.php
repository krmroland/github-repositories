<?php

namespace Tests\Feature;

use Github\Client;
use GuzzleHttp\Psr7\Response;
use Github\HttpClient\Builder;
use Http\Mock\Client as MockClient;

trait MocksGithubApiClient
{
    /**
     * The http mock client
     * @var \Http\Mock\Client
     */
    protected $mock;
    /**
     * Sets ups the test environment
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->mock = new MockClient();

        $client = new Client(new Builder($this->mock));

        //swap instance with the mock
        $this->app->instance(Client::class, $client);
    }
    /**
     * Adds a mock http response
     * @param mixed  $response
     * @param integer $status
     * @param array   $headers
     */
    protected function addMockHttpResponse($response, $status = 200, $headers = [])
    {
        $this->mock->addResponse(
            new Response($status, ['content-type' => 'Application/json'], $response)
        );

        return $this;
    }
}
