<?php

namespace App\Repositories;

use App\Models\BaseModel as Model;
use App\Contracts\Repositories\BaseRepositoryInterface as RepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class BaseRepository implements RepositoryInterface
{
    protected $model;
    protected $searchableFields;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->searchableFields = [];
    }

    /**
     * ---------------------------------------------------------------------
     * Readonly methods
     * ---------------------------------------------------------------------
     */

    public function find(int $id): ?Model
    {
        return $this->model->find($id);
    }

    public function first(): ?Model
    {
        return $this->model->first();
    }

    public function count(): int
    {
        return $this->model->count();
    }

    private function applyFilters($query, array $filters): Builder
    {
        if (isset($filters['search'])) {
            $searchTerm = '%' . $filters['search'] . '%';
            $query = $query->where(function($q) use ($searchTerm) {
                foreach ($this->searchableFields as $key => $field) {
                    if ($key === array_key_first($this->searchableFields)) {
                        $q->where($field, 'like', $searchTerm);
                    } else {
                        $q->orWhere($field, 'like', $searchTerm);
                    }
                }
            });
        }

        if (isset($filters['select'])) {
            $query->select($filters['select']);
        }

        if (isset($filters['whereConditions'])) {
            foreach ($filters['whereConditions'] as $condition) {
                $query->where($condition['field'], $condition['operator'], $condition['value']);
            }
        }

        if (isset($filters['whereInConditions'])) {
            foreach ($filters['whereInConditions'] as $condition) {
                $query->whereIn($condition['field'], $condition['values']);
            }
        }

        if (isset($filters['scopeMethods'])) {
            foreach ($filters['scopeMethods'] as $method => $parameters) {
                if (is_array($parameters)) {
                    $query->{$method}(...$parameters);
                } else {
                    $query->{$method}();
                }
            }
        }

        if (isset($filters['joins'])) {
            foreach ($filters['joins'] as $join) {
                $type = $join['type'] ?? 'inner';
                if ($type === 'inner') {
                    $query->join($join['table'], $join['first'], $join['operator'], $join['second']);
                } elseif ($type === 'left') {
                    $query->leftJoin($join['table'], $join['first'], $join['operator'], $join['second']);
                } elseif ($type === 'right') {
                    $query->rightJoin($join['table'], $join['first'], $join['operator'], $join['second']);
                }
            }
        }

        if (isset($filters['relations'])) {
            foreach ($filters['relations'] as $relation => $constraints) {
                if (is_null($constraints)) {
                    $query->with($relation);
                } else {
                    $query->with([$relation => $constraints]);
                }
            }
        }

        if (isset($filters['groupBy'])) {
            $query->groupBy($filters['groupBy']);
        }

        if (isset($filters['sortOrders'])) {
            foreach ($filters['sortOrders'] as $order) {
                $query->orderBy($order['field'], $order['direction']);
            }
        }

        return $query;
    }

    public function get(array $filters = [])
    {
        $query = $this->model->newQuery();
        $query = $this->applyFilters($query, $filters);

        if (isset($filters['lockForUpdate']) && $filters['lockForUpdate'] === true) {
            $query->lockForUpdate();
        }

        if (isset($filters['count']) && $filters['count'] === true) {
            return $query->count();
        }

        if (isset($filters['first'])) {
            return $query->first();
        }

        if (isset($filters['paginate'])) {
            if (is_int($filters['paginate'])) {
                $perPage = $filters['paginate'];
            } else {
                $perPage = 9;
            }
            return $query->paginate($perPage);
        }

        return $query->get();
    }

    /**
     * ---------------------------------------------------------------------
     * End Readonly methods
     * ---------------------------------------------------------------------
     */

    public function create(array $data): Model
    {
        return $this->model->create($data);
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
