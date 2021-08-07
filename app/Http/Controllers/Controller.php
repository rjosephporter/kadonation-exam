<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Kadonation - PHP Developer Challenge API",
 * )
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="L5 Swagger OpenApi dynamic host server"
 * )
 *
 * @OA\SecurityScheme (
 *     securityScheme="bearerAuth",
 *      type="http",
 *      scheme="bearer",
 * )
 *
 * @OA\Schema(
 *      schema="PaginationLinks",
 *      @OA\Property(property="first", type="string", example="http://localhost/api/resource?page=1"),
 *      @OA\Property(property="last", type="string", example="http://localhost/api/resource?page=5"),
 *      @OA\Property(property="prev", type="string", example="http://localhost/api/resource?page=3"),
 *      @OA\Property(property="next", type="string", example="http://localhost/api/resource?page=4")
 * )
 *
 * @OA\Schema(
 *      schema="PaginationMeta",
 *      @OA\Property(property="current_page", type="integer", example=2),
 *      @OA\Property(property="from", type="integer", example=1),
 *      @OA\Property(property="last_page", type="integer", example=5),
 *      @OA\Property(property="path", type="string", example="http://localhost/api/resource"),
 *      @OA\Property(property="per_page", type="integer", example=15),
 *      @OA\Property(property="to", type="integer", example=15),
 *      @OA\Property(property="total", type="integer", example=20)
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
