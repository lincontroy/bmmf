<?php

namespace App\Http\Controllers\Backend;

use App\Enums\PermissionActionEnum;
use App\Enums\PermissionMenuEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\SettingEmailRequest;
use App\Http\Requests\SettingEmailSendRequest;
use App\Services\SettingService;
use App\Traits\ChecksPermissionTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class SettingsEmailController extends Controller
{
    use ChecksPermissionTrait;

    public $mapActionPermission;

    /**
     * Setting Controller constructor
     *
     * @param SettingService $settingService
     */
    public function __construct(protected SettingService $settingService)
    {
        $this->mapActionPermission = [
            'index'  => PermissionMenuEnum::SETTING_EMAIL_GATEWAY->value . '.' . PermissionActionEnum::READ->value,
            'update' => PermissionMenuEnum::SETTING_EMAIL_GATEWAY->value . '.' . PermissionActionEnum::READ->value,
            'send'   => PermissionMenuEnum::SETTING_EMAIL_GATEWAY->value . '.' . PermissionActionEnum::READ->value,
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
            'title'       => localize('Email Gateway'),
            'description' => localize('Email Gateway'),
        ]);

        $formData = $this->settingService->emailFormData();
        return view('backend.setting.mail.index', $formData);
    }

    /**
     * Update
     *
     * @param SettingEmailRequest $request
     * @return JsonResponse
     */
    public function update(SettingEmailRequest $request): JsonResponse
    {
        $data = $request->validated();

        $this->settingService->updateEmail($data);

        return response()->json([
            'success' => true,
            'message' => localize("Mail setting update successfully"),
            'title'   => localize("Mail setting"),
        ]);
    }

    /**
     * Send Email
     *
     * @param SettingEmailSendRequest $request
     * @return JsonResponse
     */
    public function send(SettingEmailSendRequest $request): JsonResponse
    {
        $data = $request->validated();

        return response()->json([
            'success' => true,
            'message' => localize("Mail send successfully"),
            'title'   => localize("Mail send"),
        ]);
    }

}
