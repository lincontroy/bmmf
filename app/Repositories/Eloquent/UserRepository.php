<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Interfaces\UsersRepositoryInterface;

class UserRepository extends BaseRepository implements UsersRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
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
     * Fillable data for user
     *
     * @param array $attributes
     * @return array
     */
    private function fillable(array $attributes): array
    {
        $data = [
            'first_name' => $attributes['first_name'],
            'last_name'  => $attributes['last_name'],
            'email'      => $attributes['email'],
            'image'      => $attributes['image'] ?? null,
        ];

        if (!empty($attributes['password'])) {
            $data['password'] = bcrypt($attributes['password']);
        }

        return $data;
    }

    /**
     * @inheritDoc
     */
    public function updateAccountSetting(int $id, array $attributes): bool
    {
        $data['first_name'] = $attributes['first_name'];
        $data['last_name']  = $attributes['last_name'];
        $data['email']      = $attributes['email'];
        $data['about']      = $attributes['about'];
        $data['image']      = $attributes['image'];

        if (!empty($attributes['password'])) {
            $data['password'] = bcrypt($attributes['password']);
        }

        return parent::updateById($id, $data);
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
    public function findWithRolesPermissions(int $id): ?object
    {
        return $this->model->with(['roles', 'permissions'])->findOrFail($id);
    }

    /**
     * @inheritDoc
     */
    public function findWithRoles(int $id): ?object
    {
        return $this->model->with(['roles'])->findOrFail($id);
    }

    /**
     * @inheritDoc
     */
    public function findWithPermissions(int $id): ?object
    {
        return $this->model->with(['permissions'])->findOrFail($id);
    }

}
