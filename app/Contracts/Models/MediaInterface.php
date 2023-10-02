<?php

namespace App\Contracts\Models;

/**
 * @OA\Schema(
 *     schema="Media",
 *     required={"id", "file_path", "file_name", "mime_type"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="The unique identifier for a media item."
 *     ),
 *     @OA\Property(
 *         property="image_path",
 *         type="string",
 *         description="The path where the media file is stored."
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="The date and time the media was created."
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="The date and time the media was last updated."
 *     )
 * )
 */
interface MediaInterface
{

}
