<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\FeeSettingsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommissionRequest;
use App\Http\Requests\FeeSettingRequest;
use App\Services\CommissionSetupService;
use App\Services\FeeSettingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CommissionSettingController extends Controller
{
    /**
     * CommissionSettingController constructor
     *
     * @param CommissionSetupService $commissionSetupService
     */
    public function __construct(protected CommissionSetupService $commissionSetupService)
    {
    }

    /**
     * Index
     *
     * @return View
     */
    public function index(): View
    {
        cs_set('theme', [
            'title'       => localize('Commission Setting'),
            'description' => localize('Commission Setting'),
        ]);

        $commissions = $this->commissionSetupService->all();

        return view('backend.setting.commission', compact('commissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(CommissionRequest $request): JsonResponse
    {
        $data = $request->validated();

        $commission = $this->commissionSetupService->create($data);

        return response()->json([
            'success' => true,
            'message' => localize("Commission updated successfully"),
            'title'   => localize("Commission Setup"),
            'data'    => $commission,
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
