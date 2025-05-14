<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Server(url="http://localhost:1600")
 *
 * @OA\Info(
 *     title="Gerenciamento-Tarefas",
 *     version="0.0.1",
 *     @OA\Contact(
 *         email="danilo.britoxd@hotmail.com",
 *         name="Danilo Brito"
 *     ),
 *     @OA\License(
 *         name="GitHub Repository",
 *         url="https://github.com/danilobol/gerenciamento-tarefas"
 *     )
 * )
 *
 * @OA\ExternalDocumentation(
 *     description="Repositório no GitHub",
 *     url="https://github.com/danilobol/gerenciamento-tarefas"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
