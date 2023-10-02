<?php

namespace App\Contracts\Repositories;

use App\Models\Media;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface MediaRepositoryInterface
{
    /**
     * @throws ModelNotFoundException
     */
    public function getById(int $id): Media;

    public function create(array $data): Media;

    /**
     * @throws ModelNotFoundException
     */
    public function update(int $id, array $data): Media;

    /**
     * @throws ModelNotFoundException
     */
    public function delete(int $id): void;
}
