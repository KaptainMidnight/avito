<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\AuthenticateRequest;
use App\Http\Requests\API\SignupRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function signup(SignupRequest $request)
    {
        $user = User::query()->create([
            'name' => $request->name,
            'surname' => $request->surname,
            'phone' => $request->phone,
            'email' => $request->has('email') ? $request->email : null,
            'password' => bcrypt($request->password),
        ]);

        $token = $user->createToken($request->ip())->plainTextToken;

        return response()->json([
            'token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function authenticate(AuthenticateRequest $request)
    {
        if (! auth()->attempt($request->only(['phone', 'password']), $request->remember_me)) {
            return response()->json([
                'message' => 'Неверно введен логин или пароль'
            ], 401);
        }

        $token = auth()->user()->createToken($request->ip())?->plainTextToken;

        return response()->json([
            'token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => 'Вы вышли из аккаунта'
        ]);
    }
}
