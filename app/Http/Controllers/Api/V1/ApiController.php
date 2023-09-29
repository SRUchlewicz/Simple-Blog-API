<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

/**
 * @OA\Info(
 *   title="Blog API",
 *   version="1.0",
 *   description="A Simple Blog API",
 *   @OA\Contact(
 *     email="sebastian.ruchlewicz@gmail.com",
 *     name="Sebastian Ruchlewicz"
 *   )
 * )
 * @OA\SecurityScheme(
 *     type="http",
 *     description="Bearer Token",
 *     name="Bearer",
 *     in="header",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     securityScheme="Bearer"
 * )
 */
class ApiController extends Controller
{
    // Your methods here
}
