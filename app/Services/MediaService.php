<?php

namespace App\Services;

use App\Contracts\Services\MediaServiceInterface;
use App\Contracts\Repositories\MediaRepositoryInterface;
use App\Models\Media;
use Illuminate\Http\UploadedFile;

class MediaService implements MediaServiceInterface
{
    private $mediaRepository;

    public function __construct(
        MediaRepositoryInterface $mediaRepository
    ) {
        $this->mediaRepository = $mediaRepository;
    }

    public function uploadMedia(UploadedFile $file): Media
    {
        $path = $file->store('images', 'public');
        return $this->mediaRepository->create(['image_path' => $path]);
    }
}