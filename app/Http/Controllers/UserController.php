<?php

namespace App\Http\Controllers;

use App\DTOs\User\CreateUserDTO;
use App\DTOs\User\ForgotPasswordDTO;
use App\DTOs\User\LoginUserDTO;
use App\DTOs\User\ResetPasswordDTO;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Services\User\ForgotPasswordService;
use App\Services\User\LoginUserService;
use App\Services\User\RegisterUserService;
use App\Services\User\ResetPasswordService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(
        public readonly RegisterUserService $registerUserService,
        public readonly LoginUserService $loginUserService,
        public readonly ForgotPasswordService $forgotPasswordService,
        public readonly ResetPasswordService $resetPasswordService,
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

    /**
     * @OA\Post(
     *     path="/api/auth/forgot-password",
     *     tags={"Auth"},
     *     summary="Solicitar reset de senha",
     *     operationId="forgotPassword",
     *     @OA\Response(
     *         response=200,
     *         description="Link de recuperação enviado",
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", example="user@example.com")
     *         )
     *     )
     * )
     */
    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        try {
            $this->forgotPasswordService->execute(ForgotPasswordDTO::fromForgotPasswordRequest($request));
            return response()->json([
                'message' => 'Link de recuperação enviado para seu email'
            ]);
        } catch (\Throwable $exception) {
            return response()->json([
                'error' => 'Não foi possível processar a solicitação',
                'details' => $exception->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/auth/reset-password",
     *     tags={"Auth"},
     *     summary="Resetar senha",
     *     operationId="resetPassword",
     *     @OA\Response(
     *         response=200,
     *         description="Senha atualizada com sucesso",
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", example="user@example.com"),
     *             @OA\Property(property="token", type="string", example="token_gerado"),
     *             @OA\Property(property="password", type="string", example="nova_senha"),
     *             @OA\Property(property="password_confirmation", type="string", example="nova_senha")
     *         )
     *     )
     * )
     */
    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        try {
            $this->resetPasswordService->execute(ResetPasswordDTO::fromResetPasswordRequest($request));

            return response()->json([
                'message' => 'Senha atualizada com sucesso'
            ]);
        } catch (\Throwable $exception) {
            return response()->json([
                'error' => 'Não foi possível resetar a senha',
                'details' => $exception->getMessage(),
            ], 500);
        }
    }
}
