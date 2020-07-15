<?php

namespace App\Exceptions;

use App\User;
use Exception;

class MissingGithubTokenException extends Exception
{
    /**
     * The User Model
     *
     * @var \App\User
     */
    public $user;

    /**
     * Creates an instance of this class
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Renders the current exception into a response
     *
     * @return Response
     */
    public function render()
    {
        return response()->json(['error' => 'Missing  git-hub token'], 400);
    }
}
