<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthController extends Controller
{
    private UserService $userService;
    use RespondsWithHttpStatus;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    // Login user
    public function login(LoginRequest $request)
    {
       try{
        $this->userService->authenticate($request->validated());
       } catch (ModelNotFoundException $exception) {
        throw new AuthenticationException('Email or password incorrect');
       }
       return $this->respondWithSuccess(new UserResource(auth()->user()));
    }

    // Logout user
    public function logout()
    {
        $this->userService->logout(auth()->user());

        return $this->respondOk("Logout success");
    }
}
