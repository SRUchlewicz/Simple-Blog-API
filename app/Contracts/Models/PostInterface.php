<?php

namespace App\Contracts\Models;

/**
 * @OA\Schema(
 *     schema="Post",
 *     required={"id", "user_id", "title", "body"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="The unique identifier for a post."
 *     ),
 *     @OA\Property(
 *         property="user_id",
 *         type="integer",
 *         format="int64",
 *         description="The unique identifier for the user who created the post."
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         description="The title of the post."
 *     ),
 *     @OA\Property(
 *         property="body",
 *         type="string",
 *         description="The content of the post."
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="The date and time the post was created."
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="The date and time the post was last updated."
 *     ),
 *     @OA\Property(
 *         property="media",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Media")
 *     )
 * )
 */
interface PostInterface
{
    
}
