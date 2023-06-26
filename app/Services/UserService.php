<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public function regenerateUserToken(User $user): User
    {
        return $this->setLoginToken($user, $user->createToken('accessToken')->plainTextToken);
    }

    public function revokeLoginToken(User $user): User
    {
        return $this->setLoginToken($user, '');
    }

    public function setLoginToken(User $user, string $token): User
    {
        $user->remember_token = $token;
        $user->save();

        return $user;
    }

    public function authenticate(array $credentials): User
    {
        if(!Auth::attempt($credentials)){
            throw new ModelNotFoundException;
        }

        $user = Auth::user();
        $user = $this->regenerateUserToken($user);

        auth()->setUser($user);

        return $user;
    }

    public function logout(User $user): User
    {
        $user->currentAccessToken()->delete();
        return $this->revokeLoginToken($user, '');
    }
}
