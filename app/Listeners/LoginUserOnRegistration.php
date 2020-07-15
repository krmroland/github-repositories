<?php

namespace App\Listeners;

use Illuminate\Auth\AuthManager;
use Illuminate\Auth\Events\Registered;

class LoginUserOnRegistration
{
    /**
     * The authentication manager
     *
     * @var \Illuminate\Auth\AuthManager
     */
    protected $auth;

    /**
     * Create the event listener.
     */
    public function __construct(AuthManager $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle the event.
     *
     * @param object $event
     */
    public function handle(Registered $event)
    {
        $this->auth->login($event->user);
    }
}
