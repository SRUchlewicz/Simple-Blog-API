<?php

namespace App\Contracts\Models;

/**
 * @OA\Schema(
 *     schema="Login",
 *     required={"email", "password"},
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email"
 *     ),
 *     @OA\Property(
 *         property="password",
 *         type="string",
 *         format="password"
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="User",
 *     required={"firstname", "email", "password"},
 *     @OA\Property(
 *         property="firstname",
 *         type="string",
 *         format="string"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email"
 *     ),
 *     @OA\Property(
 *         property="password",
 *         type="string",
 *         format="password"
 *     )
 * )
 */
interface UserInterface
{
    
}