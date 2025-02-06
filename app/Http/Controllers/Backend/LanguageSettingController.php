<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\LanguagesDataTable;
use App\Enums\PermissionActionEnum;
use App\Enums\PermissionMenuEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\LanguageRequest;
use App\Models\Language;
use App\Services\LanguageService;
use App\Traits\ChecksPermissionTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LanguageSettingController extends Controller
{
    use ChecksPermissionTrait;

    public $mapActionPermission;

    /**
     * Setting Controller constructor
     *
     * @param LanguageService $languageService
     */
    public function __construct(protected LanguageService $languageService)
    {
        $this->mapActionPermission = [
            'index'   => PermissionMenuEnum::SETTING_LANGUAGE_SETTING->value . '.' . PermissionActionEnum::READ->value,
            'store'   => PermissionMenuEnum::SETTING_LANGUAGE_SETTING->value . '.' . PermissionActionEnum::READ->value,
            'edit'    => PermissionMenuEnum::SETTING_LANGUAGE_SETTING->value . '.' . PermissionActionEnum::READ->value,
            'update'  => PermissionMenuEnum::SETTING_LANGUAGE_SETTING->value . '.' . PermissionActionEnum::READ->value,
            'destroy' => PermissionMenuEnum::SETTING_LANGUAGE_SETTING->value . '.' . PermissionActionEnum::READ->value,
        ];
    }

    /**
     * Index
     *
     */
    public function index(LanguagesDataTable $dataTable)
    {
        cs_set('theme', [
            'title'       => localize('Language Setting'),
            'description' => localize('Language Setting'),
        ]);

        return $dataTable->render('backend.setting.language.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(LanguageRequest $request): JsonResponse
    {
        $data           = $request->validated();
        $data['symbol'] = strtolower($data['symbol']);

        $language = $this->languageService->create($data);

        return response()->json([
            'success' => true,
            'message' => localize("Language create successfully"),
            'title'   => localize("Language"),
            'data'    => $language,
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     * @throws Exception
     */
    public function edit(int $languageId): JsonResponse
    {
        $language = $this->languageService->findOrFail($languageId);

        return response()->json([
            'success' => true,
            'message' => localize("Language Data"),
            'title'   => localize("Language"),
            'data'    => $language,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  LanguageRequest  $request
     * @param  int  $languageId
     * @return RedirectResponse
     * @throws Exception
     */
    public function update(LanguageRequest $request, int $languageId): JsonResponse
    {
        $data                = $request->validated();
        $data['language_id'] = $languageId;
        $data['symbol']      = strtolower($data['symbol']);

        $language = $this->languageService->update($data);

        return response()->json([
            'success' => true,
            'message' => localize("Language update successfully"),
            'title'   => localize("Language"),
            'data'    => $language,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, int $id)
    {
        $this->languageService->destroy(['id' => $id]);

        return response()->json([
            'success' => true,
            'message' => localize("Language data delete successfully"),
            'title'   => localize("Language"),
        ]);

    }

}
