<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\ApiController;
use App\Contracts\Http\V1\MediaControllerInterface;
use App\Http\Requests\UploadMediaRequest;
use Illuminate\Http\JsonResponse;
use App\Contracts\Services\MediaServiceInterface;
use Illuminate\Support\Facades\Log;

class MediaController extends ApiController implements MediaControllerInterface
{
    private $mediaService;

    public function __construct(
        MediaServiceInterface $mediaService
    ) {
        $this->mediaService = $mediaService;
    }

    public function upload(UploadMediaRequest $request): JsonResponse
    {
        try {
            $this->mediaService->uploadMedia($request->file('image'));
            return response()->json(['message' => 'Media created successfully'], 201);
        } catch (\Exception $e) {
            Log::error('An error occurred during media creation: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred'], 500);
        }
    }
}
