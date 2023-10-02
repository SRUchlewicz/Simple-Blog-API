<?php

namespace App\Contracts\Models;

/**
 * @OA\Schema(
 *     schema="Role",
 *     required={"name"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="The ID of the role",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="The name of the role",
 *         example="admin"
 *     )
 * )
 */
interface RoleInterface
{

}
