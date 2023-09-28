<?php

namespace App\Repositories;

use App\Contracts\Repositories\MediaRepositoryInterface;
use App\Models\Media;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentMediaRepository implements MediaRepositoryInterface
{
    /**
     * @throws ModelNotFoundException
     */
    public function getById(int $id): Media
    {
        return Media::findOrFail($id);
    }

    public function create(array $data): Media
    {
        return Media::create($data);
    }

    /**
     * @throws ModelNotFoundException
     */
    public function update(int $id, array $data): Media
    {
        $media = $this->getById($id);
        $media->update($data);
        return $media;
    }

    /**
     * @throws ModelNotFoundException
     */
    public function delete(int $id): void
    {
        $media = $this->getById($id);
        $media->delete();
    }
}