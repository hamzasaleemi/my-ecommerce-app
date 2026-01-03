<?php

namespace App\Contracts\Repositories;

use App\Models\BaseModel as Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;

interface BaseRepositoryInterface
{
    public function find(int $id): ?Model;
    public function first(): ?Model;
    public function count(): int;
    public function get(array $filters = []);
    public function create(array $data): Model;
    public function lockForUpdate(int $id): ?Model;
    public function update(int $id, array $data): bool;
    public function destroy(array $ids): int;
}
