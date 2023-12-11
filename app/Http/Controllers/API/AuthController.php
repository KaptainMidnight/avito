<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Auth\AuthenticateRequest;
use App\Http\Requests\API\Auth\SignupRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function signup(SignupRequest $request): JsonResponse
    {
        $user = User::query()->create([
            'name' => $request->name,
            'surname' => $request->surname,
            'phone' => $request->phone,
            'email' => $request->has('email') ? $request->email : null,
            'password' => bcrypt($request->password),
        ]);

        $token = $user->createToken($request->ip())->plainTextToken;

        return json([
            'token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function authenticate(AuthenticateRequest $request): JsonResponse
    {
        if (! auth()->attempt($request->only(['phone', 'password']), $request->remember_me)) {
            return response()->json([
                'message' => 'Неверно введен логин или пароль',
            ], 401);
        }

        $token = auth()->user()->createToken($request->ip())?->plainTextToken;

        return json([
            'token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();

        return json([
            'message' => 'Вы вышли из аккаунта',
        ]);
    }
}
