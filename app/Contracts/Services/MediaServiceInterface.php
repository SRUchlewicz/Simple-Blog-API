<?php

namespace App\Contracts\Services;

use App\Models\Media;
use Illuminate\Http\UploadedFile;

interface MediaServiceInterface
{
    public function uploadMedia(UploadedFile $file): Media;
}