<?php

namespace App\Contracts\Repositories;

use App\Models\BaseModel as Model;

interface BaseRepositoryInterface
{
    public function create(array $data): Model;
    public function find(int $id): ?Model;
    public function update(int $id, array $data): bool;
    public function destroy(array $ids): int;
}
