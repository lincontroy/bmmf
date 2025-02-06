<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommissionRequest;
use App\Http\Requests\ExternalApiSettingRequest;
use App\Services\ExternalApiSetupService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExternalApiSettingController extends Controller
{
    /**
     * ExternalApiSettingController constructor
     *
     * @param ExternalApiSetupService $externalApiSetupService
     */
    public function __construct(protected ExternalApiSetupService $externalApiSetupService)
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
            'title'       => localize('External Api Setting'),
            'description' => localize('External Api Setting'),
        ]);

        $externalApi = $this->externalApiSetupService->all();

        return view('backend.setting.external_api_setup', compact('externalApi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     * @throws Exception
     */
    public function edit(int $id): JsonResponse
    {
        $external = $this->externalApiSetupService->findOrFail($id);

        return response()->json([
            'success' => true,
            'message' => localize("external api setting Data"),
            'title'   => localize("external api setting"),
            'data'    => $external,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ExternalApiSettingRequest $request
     * @param int $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function update(ExternalApiSettingRequest $request, int $id): JsonResponse
    {
        $data       = $request->validated();
        $data['id'] = $id;

        $response = $this->externalApiSetupService->update($data);

        return response()->json([
            'success' => true,
            'message' => localize("External API setting update successfully"),
            'title'   => localize("External API setting"),
            'data'    => $response,
        ]);
    }


}
