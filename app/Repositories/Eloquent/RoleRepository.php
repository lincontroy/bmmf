<?php

namespace App\Repositories\Eloquent;

use App\Models\Role;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Interfaces\RoleRepositoryInterface;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    public function __construct(Role $model)
    {
        parent::__construct($model);
    }

    /**
     * Fillable data for role
     *
     * @param  array  $attributes
     * @return array
     */
    private function fillable(array $attributes): array
    {
        return [
            'name'       => $attributes['name'],
            'guard_name' => $attributes['guard_name'],
        ];
    }

    /**
     * @inheritDoc
     */
    public function create(array $attributes): object
    {
        $data = $this->fillable($attributes);
        return parent::create($data);
    }

    /**
     * @inheritDoc
     */
    public function updateById(int $id, array $attributes): bool
    {
        $data = $this->fillable($attributes);
        return parent::updateById($id, $data);
    }

    /**
     * @inheritDoc
     */
    public function findWithPermissions(int $id): ?object
    {
        return $this->model->with(['permissions'])->findOrFail($id);
    }
}
