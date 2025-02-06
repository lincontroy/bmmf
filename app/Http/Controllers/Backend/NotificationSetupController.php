<?php

namespace App\Http\Controllers\Backend;

use App\Enums\NotificationSetupGroupEnum;
use App\Enums\PermissionActionEnum;
use App\Enums\PermissionMenuEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\NotificationSetupRequest;
use App\Services\NotificationSetupService;
use App\Traits\ChecksPermissionTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class NotificationSetupController extends Controller
{
    use ChecksPermissionTrait;

    public $mapActionPermission;

    /**
     * Setting Controller constructor
     *
     * @param NotificationSetupService $notificationSetupService
     */
    public function __construct(protected NotificationSetupService $notificationSetupService)
    {
        $this->mapActionPermission = [
            'index'  => PermissionMenuEnum::SETTING_NOTIFICATION_SETUP->value . '.' . PermissionActionEnum::READ->value,
            'update' => PermissionMenuEnum::SETTING_NOTIFICATION_SETUP->value . '.' . PermissionActionEnum::READ->value,
        ];
    }

    /**
     * Index
     *
     * @return View
     */
    public function index(): View
    {
        cs_set('theme', [
            'title'       => localize('Notification Setup'),
            'description' => localize('Notification Setup'),
        ]);

        $formData = $this->notificationSetupService->formData();

        return view('backend.setting.notification-setup.index', $formData);
    }

    /**
     * Update
     *
     * @param NotificationSetupRequest $request
     * @param NotificationSetupGroupEnum $group
     * @return JsonResponse
     */
    public function update(NotificationSetupRequest $request, NotificationSetupGroupEnum $group): JsonResponse
    {
        $data          = $request->validated();
        $data['group'] = $group;

        $this->notificationSetupService->update($data);

        return response()->json([
            'success' => true,
            'message' => localize("Notification setup update successfully"),
            'title'   => localize("Notification setup"),
            'data'    => $this->notificationSetupService->getGroupWiseNotifications($group),
        ]);
    }

}
