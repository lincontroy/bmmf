<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use App\Interfaces\ControllerInterface;
use App\DataTables\UserDataTable;
use App\Repositories\Interfaces\SystemUsersRepositoryInterface;
use App\Http\Requests\DeleteRequest;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\JsonResponse;
use App\Traits\ResponseTrait;
use Symfony\Component\HttpFoundation\Response;
use App\Enums\StatusEnum;

class UserManageController extends Controller implements ControllerInterface
{
    use ResponseTrait;

    public function __construct(
        protected SystemUsersRepositoryInterface $systemUserRepository,
    ) {
    }

    public function index(UserDataTable $dataTable)
    {
        return $dataTable->render("roles.user_list");
    }

    public function create()
    {
        // $createUser = Permission::create(['name' => 'deposit_read']);
        // $createRole = Role::create(["name" => "accounts"]);
        // $role = Role::findByName('admin');
        // $permission = Permission::findByName('usermanage_delete');
        // $role->givePermissionTo($permission);
        // $role = Role::findByName('admin');
        // auth()->user()->assignRole($role);

        // $role = $this->systemUser->find(auth()->id());
        // $role->removeRole('admin');
    }

    public function store()
    {

    }

    public function show()
    {

    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function destroy(DeleteRequest $request): JsonResponse
    {
        $deleteUser = $this->systemUserRepository->delete($request->get('id'));

        if ($deleteUser) {
            return $this->sendJsonResponse(
                'delete_user',
                StatusEnum::SUCCESS->value,
                Response::HTTP_OK,
                localize('Deleted successfully'),
                (object)[]
            );
        } else {
            return $this->sendJsonResponse(
                'delete_user',
                StatusEnum::FAILED->value,
                Response::HTTP_INTERNAL_SERVER_ERROR,
                localize('Something went wrong'),
                (object)[]
            );
        }
    }
}
