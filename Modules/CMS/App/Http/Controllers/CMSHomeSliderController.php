<?php

namespace Modules\CMS\App\Http\Controllers;

use App\Enums\PermissionActionEnum;
use App\Enums\PermissionMenuEnum;
use App\Http\Controllers\Controller;
use App\Services\ArticleDataService;
use App\Services\ArticleLangDataService;
use App\Services\ArticleService;
use App\Services\LanguageService;
use App\Traits\ChecksPermissionTrait;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Modules\CMS\App\Http\Requests\CMSHomeSliderRequest;
use Modules\CMS\App\Services\CMSHomeSliderService;
use Modules\CMS\DataTables\HomeSliderTable;

class CMSHomeSliderController extends Controller
{
    use ResponseTrait;
    use ChecksPermissionTrait;

    public $mapActionPermission;

    /**
     * CMSHomeSliderController constructor
     *
     */
    public function __construct(
        private CMSHomeSliderService $cmsHomeSliderService,
        private ArticleService $articleService,
        private ArticleDataService $articleDataService,
        private ArticleLangDataService $articleLangDataService,
        private LanguageService $languageService,
    ) {
        $this->mapActionPermission = [
            'index'          => PermissionMenuEnum::CMS_HOME_SLIDER->value . '.' . PermissionActionEnum::READ->value,
            'store'          => PermissionMenuEnum::CMS_HOME_SLIDER->value . '.' . PermissionActionEnum::READ->value,
            'edit'           => PermissionMenuEnum::CMS_HOME_SLIDER->value . '.' . PermissionActionEnum::READ->value,
            'getArticleLang' => PermissionMenuEnum::CMS_HOME_SLIDER->value . '.' . PermissionActionEnum::READ->value,
            'update'         => PermissionMenuEnum::CMS_HOME_SLIDER->value . '.' . PermissionActionEnum::READ->value,
            'destroy'        => PermissionMenuEnum::CMS_HOME_SLIDER->value . '.' . PermissionActionEnum::READ->value,
        ];
    }

    /**
     * Index
     * @param  HomeSliderTable  $dataTable
     *
     */
    public function index(HomeSliderTable $dataTable)
    {
        cs_set('theme', [
            'title'       => localize('Home Slider'),
            'description' => localize('Home Slider'),
        ]);

        $languages = $this->languageService->activeLanguages();
        return $dataTable->render('cms::home-slider.index', compact('languages'));
    }

    /**
     * Store the specified resource in storage.
     *
     * @param  CMSHomeSliderRequest  $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function store(CMSHomeSliderRequest $request): JsonResponse
    {
        $data = $request->validated();

        $article = $this->cmsHomeSliderService->create($data);

        return response()->json([
            'success' => true,
            'message' => localize("Home Slider create successfully"),
            'title'   => localize("Home Slider"),
            'data'    => $article,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $articleId
     * @return JsonResponse
     * @throws Exception
     */
    public function edit(int $articleId): JsonResponse
    {
        $languages = $this->languageService->activeLanguages();
        $article   = $this->articleService->findOrFail($articleId);

        $data            = [];
        $data['article'] = $article;
        $defaultLanguage = $languages->keyBy('symbol')[app()->getLocale()] ?? null;

        if ($article && $defaultLanguage) {
            $data['defaultLanguage'] = $defaultLanguage;
            $data['articleData']     = $this->articleDataService->all(['article_id' => $article->id, 'language_id' => $defaultLanguage->id]);
            $data['articleLangData'] = $this->articleLangDataService->all(['article_id' => $article->id, 'language_id' => $defaultLanguage->id]);
        }

        return response()->json([
            'success' => true,
            'message' => localize("Home slider Data"),
            'title'   => localize("Home slider"),
            'data'    => $data,
        ]);
    }

    /**
     * Get Article Data Lang Data for Home Slider the specified resource.
     *
     * @param  int  $languageId
     * @param  int  $articleId
     * @return JsonResponse
     * @throws Exception
     */
    public function getArticleLang(int $languageId, int $articleId): JsonResponse
    {

        $articleLangData = $this->articleLangDataService->all(['article_id' => $articleId, 'language_id' => $languageId]);

        return response()->json([
            'success' => true,
            'message' => localize("Home slider language Data"),
            'title'   => localize("Home slider language "),
            'data'    => $articleLangData,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CMSHomeSliderRequest  $request
     * @param  int  $articleId
     * @return RedirectResponse
     * @throws Exception
     */
    public function update(CMSHomeSliderRequest $request, int $articleId): JsonResponse
    {
        $data               = $request->validated();
        $data['article_id'] = $articleId;

        $article = $this->cmsHomeSliderService->update($data);

        return response()->json([
            'success' => true,
            'message' => localize("Home Slider update successfully"),
            'title'   => localize("Home Slider"),
            'data'    => $article,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $articleId
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(int $articleId)
    {
        $this->cmsHomeSliderService->destroy(['article_id' => $articleId]);

        return response()->json([
            'success' => true,
            'message' => localize("Home slider delete successfully"),
            'title'   => localize("Home slider"),
        ]);

    }

}
