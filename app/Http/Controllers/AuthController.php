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

    /**
     * @OA\Post(
     * path="/api/register",
     * operationId="Register",
     * tags={"Register"},
     * summary="User Register",
     * description="User Register here",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"name","email", "password", "password_confirmation"},
     *               @OA\Property(property="name", type="text"),
     *               @OA\Property(property="email", type="text"),
     *               @OA\Property(property="password", type="password"),
     *               @OA\Property(property="password_confirmation", type="password")
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=201,
     *          description="Register Successfully",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="Register Successfully",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
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

    /**
     * @OA\Post(
     * path="/api/login",
     * operationId="authLogin",
     * tags={"Login"},
     * summary="User Login",
     * description="Login User Here",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"email", "password"},
     *               @OA\Property(property="email", type="email"),
     *               @OA\Property(property="password", type="password")
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=201,
     *          description="Login Successfully",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="Login Successfully",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * ),
     */
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

    /**
     * @OA\Post(
     * path="/api/logout",
     * operationId="Logout User",
     * tags={"Logout"},
     * summary="User Logout",
     * description="Logout User Here",
     *      @OA\Response(
     *          response=200,
     *          description="Logout Successfully",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=401, description="You Must Be First Login"),
     * )
     */
    public function logout()
    {
        Auth::user()->tokens()->delete();
    }

    /**
     * @OA\Get(
     * path="/api/authenticate",
     * summary="Check The User Is Authenticate",
     * description="Check The User Is Authenticate",
     * tags={"UserAuthenticate"},
     * security={ {"bearer": {} }},
     *      @OA\Response(
     *          response=200,
     *          description="User Is Authenticate",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=401, description="You Must Be First Login"),
     * )
     */
    public function authenticate()
    {
        if (Auth::check()) {
            return auth()->user()->tokens;
        }
        return false;
    }
}
