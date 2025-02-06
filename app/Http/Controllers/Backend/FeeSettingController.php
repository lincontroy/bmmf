<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\FeeSettingsDataTable;
use App\Enums\PermissionActionEnum;
use App\Enums\PermissionMenuEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\FeeSettingRequest;
use App\Services\FeeSettingService;
use App\Traits\ChecksPermissionTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FeeSettingController extends Controller
{
    use ChecksPermissionTrait;

    public $mapActionPermission;

    /**
     * Setting Controller constructor
     *
     * @param FeeSettingService $feeSettingService
     */
    public function __construct(protected FeeSettingService $feeSettingService)
    {
        $this->mapActionPermission = [
            'index'   => PermissionMenuEnum::SETTING_FEE_SETTING->value . '.' . PermissionActionEnum::READ->value,
            'store'   => PermissionMenuEnum::SETTING_FEE_SETTING->value . '.' . PermissionActionEnum::READ->value,
            'edit'    => PermissionMenuEnum::SETTING_FEE_SETTING->value . '.' . PermissionActionEnum::READ->value,
            'update'  => PermissionMenuEnum::SETTING_FEE_SETTING->value . '.' . PermissionActionEnum::READ->value,
            'destroy' => PermissionMenuEnum::SETTING_FEE_SETTING->value . '.' . PermissionActionEnum::READ->value,
        ];
    }

    /**
     * Index
     *
     */
    public function index(FeeSettingsDataTable $dataTable)
    {
        cs_set('theme', [
            'title'       => localize('Fee Setting'),
            'description' => localize('Fee Setting'),
        ]);

        $data = $this->feeSettingService->formData();

        return $dataTable->render('backend.setting.fee-setting.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(FeeSettingRequest $request): JsonResponse
    {
        $data = $request->validated();

        $feeSetting = $this->feeSettingService->create($data);

        return response()->json([
            'success' => true,
            'message' => localize("Fee setting create successfully"),
            'title'   => localize("Fee setting"),
            'data'    => $feeSetting,
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     * @throws Exception
     */
    public function edit(int $feeSettingId): JsonResponse
    {
        $language = $this->feeSettingService->findOrFail($feeSettingId);

        return response()->json([
            'success' => true,
            'message' => localize("Fee setting Data"),
            'title'   => localize("Fee setting"),
            'data'    => $language,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  FeeSettingRequest  $request
     * @param  int  $feeSettingId
     * @return RedirectResponse
     * @throws Exception
     */
    public function update(FeeSettingRequest $request, int $feeSettingId): JsonResponse
    {
        $data                   = $request->validated();
        $data['fee_setting_id'] = $feeSettingId;

        $language = $this->feeSettingService->update($data);

        return response()->json([
            'success' => true,
            'message' => localize("Fee setting update successfully"),
            'title'   => localize("Fee setting"),
            'data'    => $language,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function show(Request $request, int $id)
    {
        return response()->json([
            'success' => true,
            'message' => localize("Fee setting data delete successfully"),
            'title'   => localize("Fee setting"),
        ]);

    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, int $id)
    {
        $this->feeSettingService->destroy(['fee_setting_id' => $id]);

        return response()->json([
            'success' => true,
            'message' => localize("Fee setting data delete successfully"),
            'title'   => localize("Fee setting"),
        ]);

    }

}
