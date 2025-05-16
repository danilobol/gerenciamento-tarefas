<?php

namespace App\Http\Controllers;

use App\Services\Admin\ListUsersService;
use Illuminate\Http\JsonResponse;

class AdminController extends Controller
{
    public function __construct(
        public readonly ListUsersService $listUsersService,
    ) {
    }

    /**
     * @OA\Get(
     *     path="/api/admin/users",
     *     tags={"Admin"},
     *     summary="Listar usuários paginados",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Página atual",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="perPage",
     *         in="query",
     *         description="Itens por página",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de usuários",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="name", type="string"),
     *                     @OA\Property(property="email", type="string"),
     *                     @OA\Property(property="status", type="string")
     *                 )
     *             ),
     *             @OA\Property(property="meta", type="object",
     *                 @OA\Property(property="total", type="integer"),
     *                 @OA\Property(property="currentPage", type="integer"),
     *                 @OA\Property(property="perPage", type="integer")
     *             )
     *         )
     *     )
     * )
     */
    public function listUsers(): JsonResponse
    {
        try {
            $users = $this->listUsersService->execute();
            return response()->json($users);
        } catch (\Throwable $exception) {
            return response()->json([
                'error' => 'Não foi possível listar os usuários',
                'details' => $exception->getMessage(),
            ], 500);
        }
    }
}
