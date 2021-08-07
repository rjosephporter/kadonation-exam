<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *      path="/register",
     *      tags={"Auth"},
     *      summary="Register a user",
     *
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="name", type="string", example="Richard Joseph Porter"),
     *              @OA\Property(property="email", type="string", example="richard@example.com"),
     *              @OA\Property(property="password", type="string", example="password"),
     *              @OA\Property(property="password_confirmation", type="string", example="password")
     *          )
     *     ),
     *
     *     @OA\Response(
     *          response="201",
     *          description="Created",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="object", ref="#/components/schemas/User"),
     *          ),
     *      )
     * )
     *
     * @param RegisterRequest $request
     * @return UserResource
     */
    public function register(RegisterRequest $request)
    {
        return new UserResource(
            User::create($request->only([
                'name',
                'email',
                'password',
            ]))
        );
    }

    /**
     * @OA\Post(
     *      path="/login",
     *      tags={"Auth"},
     *      summary="Login a user",
     *
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="email", type="string", example="richard@example.com"),
     *              @OA\Property(property="password", type="string", example="password")
     *          )
     *     ),
     *
     *     @OA\Response(
     *          response="200",
     *          description="Created",
     *          @OA\JsonContent(
     *              @OA\Property(property="token", type="string"),
     *          ),
     *      )
     * )
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return response()->json([
            'token' => $user->createToken(config('app.name'))->plainTextToken
        ]);
    }
}
