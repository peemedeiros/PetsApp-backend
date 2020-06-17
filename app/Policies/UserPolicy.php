<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Tymon\JWTAuth\Contracts\Providers\Auth;
use Tymon\JWTAuth\JWTAuth;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, User $model)
    {
        return $user->id === $model->id;
    }
}
