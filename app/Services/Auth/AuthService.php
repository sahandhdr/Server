<?php

namespace App\Services\Auth;

use App\Http\Resources\Api\v1\User\UserResource;
use App\Models\User;
use App\Services\Interfaces\Auth\AuthServiceInterfaces;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthService implements AuthServiceInterfaces
{
    public function register(array $attributes): array
    {

        if (User::where("mobile", $attributes['mobile'])->exists() && User::where("email", $attributes['email'])->exists())
            return ['message' => 'user-exists'];

            $user = new User();
            $user->name = $attributes['name'];
            $user->surname = $attributes['surname'];
            $user->password = Hash::make($attributes['password']);
            $user->mobile = $attributes['mobile'];
            $user->email = $attributes['email'];
            $user->birthday = $attributes['birthday'];
            $user->gender = $attributes['gender'];
            $user->ncode = $attributes['ncode'];

            if ($user->save())
            {
                $token = $user->createToken('sanctum')->plainTextToken;
                return [
                        'message' => 'success',
                        'data' => [
                            'user' => new UserResource($user->refresh()),
                            'token' => $token
                        ]
                ];
            }
            return ['message' => 'save-failed'];
    }

    public function login(array $attributes): array
    {
        $user = User::with('roles')->where('mobile', $attributes['mobile'])->first();

        if (!$user)
            return ['message' => 'user-notFound'];

        if (!Hash::check($attributes['password'], $user->password))
            return ['message' => 'password-notMatch'];

        $token = $user->createToken('passport')->plainTextToken;

        if (!isset($token))
            return ['message' => 'token-notFound'];

        return [
            'message' => 'success',
            'data' => [
                'user' => new UserResource($user),
                'token' => $token,
            ]
        ];
    }

    public function logout(): array
    {
        if (!auth()->user())
            return ['message' => 'Unauthenticated'];

        return auth()->user()->currentAccessToken()->delete() ? ['message' => 'logout-success'] : ['message' => 'logout-failed'];
    }

    public function changePassword(array $data, $user_id): array
    {
        if ($data['newPassword'] !== $data['confirmPassword'])
            return ['message' => 'newpasswords-notMatch'];

        if (!DB::table('users')->where('id', $user_id)->exists())
            return ['message' => 'user-notFound'];
        $user = User::findOrFail($user_id);

        if (!Hash::check($data['oldPassword'],$user->password))
            return ['message' => 'password-notMatch'];

    $user->password = Hash::make($data['newPassword']);

        if (!$user->save())
            return ['message' => 'password-changingFailed'];

        return ['message' => 'success'];
    }
}
