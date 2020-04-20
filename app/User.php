<?php

namespace App;

use App\Casts\Encrypted;
use Illuminate\Notifications\Notifiable;
use App\Services\GitHub\Contracts\GithubApi;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Exceptions\MissingGithubTokenException;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'github_token'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'github_token' => Encrypted::class,
    ];
    /**
     * Sets the password attribute
     * @param string $password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }
    /**
     * The users github client
     * @throws App\Exceptions\MissingGithubTokenException
     * @return \App\User\UserGithubTokenClient
     */
    public function gitHub()
    {
        if (blank($this->github_token)) {
            throw new MissingGithubTokenException($this);
        }

        return tap(app(GithubApi::class))->authenticateUsingToken($this->github_token);
    }
}
