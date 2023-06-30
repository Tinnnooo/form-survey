<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Auth\AuthenticationException;

class AuthController extends Controller
{
    use RespondsWithHttpStatus;

    // Login user
    public function login(LoginRequest $request)
    {
        if (! auth()->once($request->validated())) {
            throw new AuthenticationException('Email or password incorrect');
        }

        return $this->respondWithSuccess(new UserResource(auth()->user()));
    }

    // Logout user
    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();

        return $this->respondOk('Logout success');
    }
}
