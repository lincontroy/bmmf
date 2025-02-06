<?php

namespace App\Http\Controllers\Backend;

use App\Enums\PermissionActionEnum;
use App\Enums\PermissionMenuEnum;
use App\Facades\Localizer;
use App\Http\Controllers\Controller;
use App\Http\Requests\BuildLanguageRequest;
use App\Services\BuildService;
use App\Services\LanguageService;
use App\Traits\ChecksPermissionTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BuildLanguageSettingController extends Controller
{
    use ChecksPermissionTrait;

    public $mapActionPermission;

    /**
     * Setting Controller constructor
     *
     * @param BuildService $buildService
     */
    public function __construct(
        protected BuildService $buildService,
        protected LanguageService $languageService,
    ) {
        $this->mapActionPermission = [
            'index'         => PermissionMenuEnum::SETTING_LANGUAGE_SETTING->value . '.' . PermissionActionEnum::READ->value,
            'dataTableAjax' => PermissionMenuEnum::SETTING_LANGUAGE_SETTING->value . '.' . PermissionActionEnum::READ->value,
            'store'         => PermissionMenuEnum::SETTING_LANGUAGE_SETTING->value . '.' . PermissionActionEnum::READ->value,
            'update'        => PermissionMenuEnum::SETTING_LANGUAGE_SETTING->value . '.' . PermissionActionEnum::READ->value,
            'destroy'       => PermissionMenuEnum::SETTING_LANGUAGE_SETTING->value . '.' . PermissionActionEnum::READ->value,
        ];
    }

    /**
     * Index
     *
     */
    public function index(int $languageId)
    {
        cs_set('theme', [
            'title'       => localize('Language Build'),
            'description' => localize('Language Build'),
        ]);

        $formData = $this->buildService->formData($languageId);

        return view('backend.setting.language.build.index', $formData);
    }

    /**
     * Datatable Ajax
     *
     * @param Request $request
     */
    public function dataTableAjax($code, Request $request)
    {
        $localize = Localizer::getLocalizeData($code);

        $language = $this->languageService->findByAttributes(['symbol' => $code]);

        // convert array to collection key  is a new key and value is a new key
        $localize = collect($localize)->map(function ($item, $key) {
            return [
                'key'   => $key,
                'value' => $item,
            ];
        });

        return DataTables::of($localize)
            ->addColumn('action', function ($item) use ($language) {
                $button = '<div class="d-flex align-items-center">';

                $button .= '<a href="javascript:void(0);" class="btn btn-info-soft btn-sm m-1 edit-build-button" title="' . localize("Edit") . '"
                data-key="' . $item['key'] . '" data-value="' . $item['value'] . '"
                data-action="' . route('admin.setting.language.build.update', ['language' => $language->id, 'key' => $item['key']]) . '"
                ><i class="fa fa-edit"></i></a>';

                // You can add form elements or buttons for actions here
                $button .= '<a href="javascript:void(0);" class="btn btn-danger-soft btn-sm m-1 delete-button" title="' . localize("Delete") . '" data-action="' . route('admin.setting.language.build.destroy', ['language' => $language->id, 'key' => $item['key']]) . '"><i class="fa fa-trash"></i></a>';
                $button .= '</div>';

                return $button;

            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(BuildLanguageRequest $request, int $languageId): JsonResponse
    {
        $data = $request->validated();

        $data['language_id'] = $languageId;

        $this->buildService->create($data);

        return response()->json([
            'success' => true,
            'message' => localize("Language build create successfully"),
            'title'   => localize("Language build"),
            'data'    => [],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  BuildLanguageRequest  $request
     * @param  int  $languageId
     * @return RedirectResponse
     * @throws Exception
     */
    public function update(BuildLanguageRequest $request, int $languageId, string $key): JsonResponse
    {
        $data                = $request->validated();
        $data['language_id'] = $languageId;
        $data['build_key']   = $key;

        $language = $this->buildService->update($data);

        return response()->json([
            'success' => true,
            'message' => localize("Language build update successfully"),
            'title'   => localize("Language build"),
            'data'    => $language,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, int $languageId, string $key)
    {
        $this->buildService->destroy(['language_id' => $languageId, 'key' => $key]);

        return response()->json([
            'success' => true,
            'message' => localize("Language build data delete successfully"),
            'title'   => localize("Language build"),
        ]);

    }

}
