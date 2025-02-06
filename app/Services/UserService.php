<?php

namespace App\Services;

use App\Helpers\ImageHelper;
use App\Repositories\Interfaces\PermissionRepositoryInterface;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\Interfaces\UsersRepositoryInterface;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;

class UserService
{
    /**
     * UserService constructor.
     *
     * @param UsersRepositoryInterface $userRepository
     */

    public function __construct(
        private UsersRepositoryInterface $userRepository,
        private PermissionRepositoryInterface $permissionRepository,
        private RoleRepositoryInterface $roleRepository,
        protected PermissionService $permissionService,
    ) {

    }

    /**
     * Find user or throw 404
     *
     * @param  int  $id
     * @return array
     */
    public function formData(): array
    {
        $groups = $this->permissionService->groupsAndSubgroups();
        $roles  = $this->roleRepository->all();

        return compact('groups', 'roles');
    }

    /**
     * Find user or throw 404
     *
     * @param  int  $id
     * @return array
     */
    public function findOrFail(int $id): object
    {
        return $this->userRepository->findOrFail($id);
    }

    /**
     * Find user with roles and permission or throw 404
     *
     * @param  int  $id
     * @return array
     */
    public function findWithRolesPermissions(int $id): object
    {
        return $this->userRepository->findWithRolesPermissions($id);
    }

    /**
     * Find user with roles or throw 404
     *
     * @param  int  $id
     * @return array
     */
    public function findWithRoles(int $id): object
    {
        return $this->userRepository->findWithRoles($id);
    }

    /**
     * Find user with permission or throw 404
     *
     * @param  int  $id
     * @return array
     */
    public function findWithPermissions(int $id): object
    {
        return $this->userRepository->findWithPermissions($id);
    }

    /**
     * Create user
     *
     * @param  array  $attributes
     * @return object
     * @throws Exception
     */
    public function create(array $attributes): object
    {
        $attributes['image'] = ImageHelper::upload($attributes['image'] ?? null, 'user');

        try {
            DB::beginTransaction();

            $user = $this->userRepository->create($attributes);
            $user->assignRole(array_map('intval', $attributes['role_id'] ?? []));

            $user->syncPermissions(array_map('intval', $attributes['permissions'] ?? []));

            DB::commit();

            return $user;

        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("User create error"),
                'title'   => localize("User"),
                'errors'  => $exception,
            ], 422));
        }

    }

    /**
     * Update user
     *
     * @param  array  $attributes
     * @return bool
     * @throws Exception
     */
    public function update(array $attributes): bool
    {
        $userId              = $attributes['user_id'];
        $user                = $this->userRepository->first($userId);
        $attributes['image'] = ImageHelper::upload($attributes['image'] ?? null, 'user', $user->image ?? null);
        $roleIds             = $attributes['role_id'] ?? [];
        $permissions         = $attributes['permissions'] ?? [];

        try {
            DB::beginTransaction();

            $this->userRepository->updateById($userId, $attributes);

            $user = $this->userRepository->find($userId);

            if ($roleIds) {
                $user->assignRole(array_map('intval', $attributes['role_id']));
            } else {
                $user->roles()->detach();
            }

            $user->syncPermissions(array_map('intval', $permissions));

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("User update error"),
                'title'   => localize("User"),
                'errors'  => $exception,
            ], 422));
        }

    }

    /**
     * Update application setting
     *
     * @param  array  $attributes
     * @return bool
     * @throws Exception
     */
    public function updateAccountSetting(array $attributes): bool
    {
        $user = $this->userRepository->find($attributes['user_id']);

        $attributes['image'] = ImageHelper::upload($attributes['image'] ?? null, 'user', $user->image ?? null);

        try {
            DB::beginTransaction();

            $this->userRepository->updateAccountSetting($user->id, $attributes);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("Account setting update error"),
                'title'   => localize("Account setting"),
                'errors'  => $exception,
            ], 422));
        }

    }

    /**
     * Delete user
     *
     * @param  array  $attributes
     * @return bool
     * @throws Exception
     */
    public function destroy(array $attributes): bool
    {
        $userId = $attributes['user_id'];

        $user = $this->userRepository->find($userId);

        try {
            DB::beginTransaction();

            $user->assignRole([]);
            $user->syncPermissions([]);

            if ($user && $user->image) {
                delete_file('public/' . $user->image);
            }

            $this->userRepository->destroyById($userId);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("User delete error"),
                'title'   => localize("User delete error"),
                'errors'  => $exception,
            ], 422));
        }

    }

}
