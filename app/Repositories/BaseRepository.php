<?php

namespace App\Repositories;

use App\Models\BaseModel as Model;
use App\Contracts\Repositories\BaseRepositoryInterface as RepositoryInterface;

class BaseRepository implements RepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function find(int $id): ?Model
    {
        return $this->model->find($id);
    }

    public function update(int $id, array $data): bool
    {
        $record = $this->model->find($id);
        if ($record) {
            return $record->update($data);
        }
        return false;
    }

    public function destroy(array $ids): int
    {
        return $this->model->destroy($ids);
    }
}
