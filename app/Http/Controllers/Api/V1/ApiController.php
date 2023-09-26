<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

/**
 * @OA\Info(
 *   title="My API",
 *   version="1.0",
 *   description="A description of my API",
 *   @OA\Contact(
 *     email="support@example.com",
 *     name="Support Team"
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
