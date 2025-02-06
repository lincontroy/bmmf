<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\UsersDataTable;
use App\Enums\PermissionActionEnum;
use App\Enums\PermissionMenuEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\AccountSettingRequest;
use App\Http\Requests\UserRequest;
use App\Services\PermissionService;
use App\Services\UserService;
use App\Traits\ChecksPermissionTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    use ChecksPermissionTrait;

    public $mapActionPermission;

    /**
     * AccessoriesController constructor
     *
     * @param  UserService  $userService
     * @param  PermissionService  $permissionService
     */
    public function __construct(
        protected UserService $userService,
        protected PermissionService $permissionService
    ) {
        $this->mapActionPermission = [
            'index'   => PermissionMenuEnum::MANAGES_USER->value . '.' . PermissionActionEnum::READ->value,
            'create'  => PermissionMenuEnum::MANAGES_USER->value . '.' . PermissionActionEnum::CREATE->value,
            'store'   => PermissionMenuEnum::MANAGES_USER->value . '.' . PermissionActionEnum::CREATE->value,
            'edit'    => PermissionMenuEnum::MANAGES_USER->value . '.' . PermissionActionEnum::UPDATE->value,
            'update'  => PermissionMenuEnum::MANAGES_USER->value . '.' . PermissionActionEnum::UPDATE->value,
            'destroy' => PermissionMenuEnum::MANAGES_USER->value . '.' . PermissionActionEnum::DELETE->value,
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(UsersDataTable $dataTable)
    {
        cs_set('theme', [
            'title'       => localize('User'),
            'description' => localize('User'),
        ]);

        $formData = $this->userService->formData();

        return $dataTable->render('backend.user.index', $formData);
    }

    /**
     * Show
     *
     * @param integer $id
     * @return view
     */
    public function show(int $id): view
    {
        $user = $this->userService->findOrFail($id);

        return view('backend.user.profile', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(UserRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = $this->userService->create($data);

        return response()->json([
            'success' => true,
            'message' => localize("User create successfully"),
            'title'   => localize("User"),
            'data'    => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return View
     * @throws AuthorizationException
     */
    public function edit(int $userId): JsonResponse
    {
        $user = $this->userService->findWithRolesPermissions($userId);

        return response()->json([
            'success' => true,
            'message' => localize("User Data"),
            'title'   => localize("User"),
            'data'    => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserRequest  $request
     * @param  int  $userId
     * @return RedirectResponse
     * @throws AuthorizationException
     * @throws Exception
     */
    public function update(UserRequest $request, int $userId)
    {
        $data            = $request->validated();
        $data['user_id'] = $userId;

        $user = $this->userService->update($data);

        return response()->json([
            'success' => true,
            'message' => localize("User update successfully"),
            'title'   => localize("User"),
            'data'    => $user,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, int $id)
    {
        $this->userService->destroy(['user_id' => $id]);

        return response()->json([
            'success' => true,
            'message' => localize("User data delete successfully"),
            'title'   => localize("User"),
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $userId
     * @return View
     * @throws AuthorizationException
     */
    public function accountSetting(int $userId): view
    {
        cs_set('theme', [
            'title'       => localize('User Account Setting'),
            'description' => localize('User Account Setting'),
        ]);

        $user = $this->userService->findOrFail($userId);

        return view('backend.user.account_setting', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AccountSettingRequest  $request
     * @param  int  $userId
     * @return RedirectResponse
     * @throws AuthorizationException
     * @throws Exception
     */
    public function updateAccountSetting(AccountSettingRequest $request, int $userId): JsonResponse
    {
        $data            = $request->validated();
        $data['user_id'] = $userId;

        $this->userService->updateAccountSetting($data);

        $user = $this->userService->findOrFail($userId);

        if ($user) {
            $user->append(['image_url']);
        }

        return response()->json([
            'success' => true,
            'message' => localize("User account update successfully"),
            'title'   => localize("User"),
            'data'    => $user,
        ]);
    }

}
