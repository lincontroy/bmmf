<?php

namespace App\Services;

use App\Repositories\Interfaces\RoleRepositoryInterface;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RoleService
{
    /**
     * RoleService constructor.
     *
     * @param RoleRepositoryInterface $roleRepository
     */
    public function __construct(
        private RoleRepositoryInterface $roleRepository,
    ) {

    }

    /**
     * Find role or throw 404
     *
     * @param  int  $id
     * @return array
     */
    public function findOrFail(int $id): object
    {
        return $this->roleRepository->findOrFail($id, ['']);
    }

    /**
     * Find role with permission or throw 404
     *
     * @param  int  $id
     * @return array
     */
    public function findWithPermissions(int $id): object
    {
        return $this->roleRepository->findWithPermissions($id);
    }

    /**
     * Create role
     *
     * @param  array  $attributes
     * @return object
     * @throws Exception
     */
    public function create(array $attributes): object
    {
        try {
            DB::beginTransaction();
            $attributes['guard_name'] = Auth::getDefaultDriver();

            $role = $this->roleRepository->create($attributes);

            $role->syncPermissions(array_map('intval', $attributes['permissions'] ?? []));

            DB::commit();

            return $role;

        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("Role create error"),
                'title'   => localize("Role"),
                'errors'  => $exception,
            ], 422));
        }
    }

    /**
     * Update role
     *
     * @param  array  $attributes
     * @return bool
     * @throws Exception
     */
    public function update(array $attributes): bool
    {
        $roleId = $attributes['role_id'];

        try {
            DB::beginTransaction();
            $attributes['guard_name'] = Auth::getDefaultDriver();
            $this->roleRepository->updateById($roleId, $attributes);

            $role = $this->roleRepository->find($roleId);

            $role->syncPermissions(array_map('intval', $attributes['permissions'] ?? []));

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("Role update error"),
                'title'   => localize("Role"),
                'errors'  => $exception,
            ], 422));
        }
    }

    /**
     * Delete role
     *
     * @param  array  $attributes
     * @return bool
     * @throws Exception
     */
    public function destroy(array $attributes): bool
    {
        $roleId = $attributes['role_id'];

        try {
            DB::beginTransaction();

            $role = $this->roleRepository->find($roleId);

            $role->syncPermissions([]);

            $this->roleRepository->destroyById($roleId);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("Role delete error"),
                'title'   => localize("Role delete error"),
                'errors'  => $exception,
            ], 422));
        }
    }

}
