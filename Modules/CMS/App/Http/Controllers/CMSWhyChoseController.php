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
use Modules\CMS\App\Http\Requests\CMSWhyChoseContentRequest;
use Modules\CMS\App\Services\CMSWhyChoseContentService;
use Modules\CMS\App\Services\CMSWhyChoseHeaderService;
use Modules\CMS\DataTables\WhyChoseContentTable;

class CMSWhyChoseController extends Controller
{
    use ResponseTrait;
    use ChecksPermissionTrait;

    public $mapActionPermission;

    /**
     * CMSWhyChoseController constructor
     *
     */
    public function __construct(
        private CMSWhyChoseHeaderService $cmsWhyChoseHeaderService,
        private CMSWhyChoseContentService $cmsWhyChoseContentService,
        private ArticleService $articleService,
        private ArticleDataService $articleDataService,
        private ArticleLangDataService $articleLangDataService,
        private LanguageService $languageService,
    ) {
        $this->mapActionPermission = [
            'index'          => PermissionMenuEnum::CMS_WHY_CHOSE->value . '.' . PermissionActionEnum::READ->value,
            'store'          => PermissionMenuEnum::CMS_WHY_CHOSE->value . '.' . PermissionActionEnum::READ->value,
            'edit'           => PermissionMenuEnum::CMS_WHY_CHOSE->value . '.' . PermissionActionEnum::READ->value,
            'getArticleLang' => PermissionMenuEnum::CMS_WHY_CHOSE->value . '.' . PermissionActionEnum::READ->value,
            'update'         => PermissionMenuEnum::CMS_WHY_CHOSE->value . '.' . PermissionActionEnum::READ->value,
            'destroy'        => PermissionMenuEnum::CMS_WHY_CHOSE->value . '.' . PermissionActionEnum::READ->value,
        ];
    }

    /**
     * Index
     *
     */
    public function index(WhyChoseContentTable $dataTable)
    {
        cs_set('theme', [
            'title'       => localize('Why Chose'),
            'description' => localize('Why Chose'),
        ]);


        $languages = $this->languageService->activeLanguages();
        $article   = $this->articleService->whyChoseHeader();

        return $dataTable->render('cms::why-chose.index', compact('languages', 'article'));
    }

    /**
     * Store the specified resource in storage.
     *
     * @param  CMSMerchantContentRequest  $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function store(CMSWhyChoseContentRequest $request): JsonResponse
    {
        $data = $request->validated();

        $article = $this->cmsWhyChoseContentService->create($data);

        return response()->json([
            'success' => true,
            'message' => localize("Why Chose Content create successfully"),
            'title'   => localize("Why Chose Content"),
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
            'message' => localize("Why Chose Content Data"),
            'title'   => localize("Why Chose Content"),
            'data'    => $data,
        ]);
    }

    /**
     * Get Article Data Lang Data for Why chose content the specified resource.
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
            'message' => localize("Why Chose Content language Data"),
            'title'   => localize("Why Chose Content language "),
            'data'    => $articleLangData,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CMSWhyChoseContentRequest  $request
     * @param  int  $languageId
     * @return RedirectResponse
     * @throws Exception
     */
    public function update(CMSWhyChoseContentRequest $request, int $articleId): JsonResponse
    {
        $data               = $request->validated();
        $data['article_id'] = $articleId;

        $article = $this->cmsWhyChoseContentService->update($data);

        return response()->json([
            'success' => true,
            'message' => localize("Why Chose Content update successfully"),
            'title'   => localize("Why Chose Content"),
            'data'    => $article,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $this->cmsWhyChoseContentService->destroy(['article_id' => $id]);

        return response()->json([
            'success' => true,
            'message' => localize("Why Chose Content delete successfully"),
            'title'   => localize("Why Chose Content"),
        ]);

    }

}
