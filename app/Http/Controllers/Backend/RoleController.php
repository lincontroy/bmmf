<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\RolesDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Services\PermissionService;
use App\Services\RoleService;
use App\Traits\ChecksPermissionTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Enums\PermissionActionEnum;
use App\Enums\PermissionMenuEnum;

class RoleController extends Controller
{

    use ChecksPermissionTrait;

    public $mapActionPermission;

    /**
     * AccessoriesController constructor
     *
     * @param  RoleService  $roleService
     */
    public function __construct(
        protected RoleService $roleService,
        protected PermissionService $permissionService
    ) {
        $this->mapActionPermission = [
            'index'   => PermissionMenuEnum::MANAGES_ROLE->value  . '.' . PermissionActionEnum::READ->value,
            'create'  => PermissionMenuEnum::MANAGES_ROLE->value  . '.' . PermissionActionEnum::CREATE->value,
            'store'   => PermissionMenuEnum::MANAGES_ROLE->value  . '.' . PermissionActionEnum::CREATE->value,
            'edit'    => PermissionMenuEnum::MANAGES_ROLE->value  . '.' . PermissionActionEnum::UPDATE->value,
            'update'  => PermissionMenuEnum::MANAGES_ROLE->value  . '.' . PermissionActionEnum::UPDATE->value,
            'destroy' => PermissionMenuEnum::MANAGES_ROLE->value  . '.' . PermissionActionEnum::DELETE->value,
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(RolesDataTable $dataTable)
    {
        cs_set('theme', [
            'title'       => localize('Role'),
            'description' => localize('Role'),
        ]);

        $groups = $this->permissionService->groupsAndSubgroups();

        return $dataTable->render('backend.role.index', compact('groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(RoleRequest $request): JsonResponse
    {
        $data = $request->validated();

        $role = $this->roleService->create($data);

        return response()->json([
            'success' => true,
            'message' => localize("Role create successfully"),
            'title'   => localize("Role"),
            'data'    => $role,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return View
     * @throws AuthorizationException
     */
    public function edit(int $roleId): JsonResponse
    {
        $role = $this->roleService->findWithPermissions($roleId);

        return response()->json([
            'success' => true,
            'message' => localize("Role Data"),
            'title'   => localize("Role"),
            'data'    => $role,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  RoleRequest  $request
     * @param  int  $roleId
     * @return RedirectResponse
     * @throws AuthorizationException
     * @throws Exception
     */
    public function update(RoleRequest $request, int $roleId)
    {
        $data            = $request->validated();
        $data['role_id'] = $roleId;

        $role = $this->roleService->update($data);

        return response()->json([
            'success' => true,
            'message' => localize("Role update successfully"),
            'title'   => localize("Role"),
            'data'    => $role,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, int $id)
    {
        $this->roleService->destroy(['role_id' => $id]);

        return response()->json([
            'success' => true,
            'message' => localize("Role data delete successfully"),
            'title'   => localize("Role"),
        ]);

    }

}
