<?php

namespace App\Http\Controllers;

use App\DTOs\User\CreateUserDTO;
use App\DTOs\User\LoginUserDTO;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Services\User\LoginUserService;
use App\Services\User\RegisterUserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(
        public readonly RegisterUserService $registerUserService,
        public readonly LoginUserService $loginUserService,
    ) {
    }

    /**
     * @OA\Post(
     *     path="/api/auth/register",
     *     tags={"Auth"},
     *     summary="Registro de novos usuarios",
     *     operationId="registerUser",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *         type="object",
     *          @OA\Property(property="email", type="string", example="danilo@gerenciamento.com"),
     *          @OA\Property(property="name", type="string", example="Danilo"),
     *          @OA\Property(property="password", type="string", example="123456"),
     *          )
     *     )
     * )
     *
     * @param RegisterUserRequest $request
     * @return JsonResponse
     */
    public function register(RegisterUserRequest $request): JsonResponse
    {
        try {
            return response()->json([
                $this->registerUserService->execute(CreateUserDTO::fromRegisterUserRequest($request)),
            ], 201);
        } catch (\Throwable $exception) {
            return response()->json([
                'error' => 'Não foi possível criar usuário.',
                'details' => $exception->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     tags={"Auth"},
     *     summary="Login usuarios",
     *     operationId="loginUser",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *         type="object",
     *          @OA\Property(property="email", type="string", example="danilo@gerenciamento.com"),
     *          @OA\Property(property="password", type="string", example="123456"),
     *          )
     *     )
     * )
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            return response()->json(
                $this->loginUserService->execute(LoginUserDTO::fromLoginRequest($request)),
            );
        } catch (\Throwable $exception) {
            return response()->json([
                'error' => 'Não foi possível autenticar usuário.',
                'details' => $exception->getMessage(),
            ], 500);
        }
    }
}
