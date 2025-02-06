<?php

namespace App\Http\Controllers\Backend;

use App\Enums\PermissionActionEnum;
use App\Enums\PermissionMenuEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;
use App\Services\SettingService;
use App\Traits\ChecksPermissionTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class SettingsController extends Controller
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
            'index'  => PermissionMenuEnum::SETTING_APP_SETTING->value . '.' . PermissionActionEnum::READ->value,
            'update' => PermissionMenuEnum::SETTING_APP_SETTING->value . '.' . PermissionActionEnum::READ->value,
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
            'title'       => localize('Application Setting'),
            'description' => localize('Application Setting'),
        ]);

        $formData = $this->settingService->formData();

        return view('backend.setting.index', $formData);
    }

    /**
     * Update
     *
     * @param SettingRequest $request
     * @return JsonResponse
     */
    public function update(SettingRequest $request): JsonResponse
    {
        $data = $request->validated();

        $this->settingService->update($data);

        return response()->json([
            'success' => true,
            'message' => localize("Application setting update successfully"),
            'title'   => localize("Application setting"),
            'data'    => $this->settingService->findById(),
        ]);
    }

}
