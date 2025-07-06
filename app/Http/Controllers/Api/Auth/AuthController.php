<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\v1\ApiController;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Api\v1\User\UserResource;
use App\Services\Interfaces\Auth\AuthServiceInterfaces;


class AuthController extends ApiController
{
    public AuthServiceInterfaces $authService;

    public function __construct(AuthServiceInterfaces $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        $user = $this->authService->register($request->validated());
        if ($user['message'] === 'success')
            return $this->successResponse(new UserResource($user['data']['user']), 200);
        return $this->errorResponse($user['message'], 500);
    }

    public function login(LoginRequest $request)
    {
        $data = $this->authService->login($request->validated());
        if ($data['message'] !== 'success')
            return $this->errorResponse($data['message'], 401);
        return $this->successResponse($data['data'], 200);
    }

    public function logout()
    {
        $message = $this->authService->logout();
        if ($message['message'] !== 'logout-success')
            return $this->errorResponse($message['message'], 401);
        return $this->successResponse('', 200, $message['message']);
    }

    public function changePassword(ChangePasswordRequest $request, $user_id)
    {
        $message = $this->authService->changePassword($request->validated(), $user_id)['message'];
        if($message === 'success')
            return $this->successResponse('', 200, 'password-changed-successfully');
        return $this->errorResponse($message, 500);
    }
}
