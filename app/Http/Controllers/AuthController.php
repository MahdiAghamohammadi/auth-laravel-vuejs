<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use \Exception;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        try {
            $inputs = $request->all();
            $inputs['password'] = Hash::make($inputs['password']);
            $user = User::create($inputs);
            return response()->json([
                'data' => 'User created successfully',
                'success' => true,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'data' => $e->getMessage(),
                'success' => false,
            ], 422);
        }
    }

    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            $token = $user->createToken('token')->plainTextToken;
            // $cookie = cookie('jwt', $token, 60 * 24); // 1 day
            return (new UserResource($user))->token($token);
        }
        throw ValidationException::withMessages([
            'email' => 'The provided credentials are incorrect',
        ]);
    }

    public function authenticate()
    {
        if (Auth::check()) {
            return true;
        } else {
            return false;
        }
    }

    public function logout()
    {
        Auth::logout();
    }
}
