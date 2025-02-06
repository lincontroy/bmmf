<?php

namespace App\Http\Controllers\Backend;

use App\Enums\PermissionActionEnum;
use App\Enums\PermissionMenuEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\SettingSMSRequest;
use App\Http\Requests\SettingSMSSendRequest;
use App\Services\SettingService;
use App\Traits\ChecksPermissionTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class SettingsSMSController extends Controller
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
            'index'  => PermissionMenuEnum::SETTING_SMS_GATEWAY->value . '.' . PermissionActionEnum::READ->value,
            'update' => PermissionMenuEnum::SETTING_SMS_GATEWAY->value . '.' . PermissionActionEnum::READ->value,
            'send'   => PermissionMenuEnum::SETTING_SMS_GATEWAY->value . '.' . PermissionActionEnum::READ->value,
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
            'title'       => localize('SMS Gateway'),
            'description' => localize('SMS Gateway'),
        ]);

        $formData = $this->settingService->smsFormData();

        return view('backend.setting.sms.index', $formData);
    }

    /**
     * Update
     *
     * @param SettingSMSRequest $request
     * @return JsonResponse
     */
    public function update(SettingSMSRequest $request): JsonResponse
    {
        $data = $request->validated();

        $this->settingService->updateSMS($data);

        return response()->json([
            'success' => true,
            'message' => localize("sms setting update successfully"),
            'title'   => localize("sms setting"),
        ]);
    }

    /**
     * Send sms
     *
     * @param SettingSMSSendRequest $request
     * @return JsonResponse
     */
    public function send(SettingSMSSendRequest $request): JsonResponse
    {
        $data = $request->validated();

        return response()->json([
            'success' => true,
            'message' => localize("SMS send update successfully"),
            'title'   => localize("SMS send"),
        ]);
    }

}
