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
use Modules\CMS\App\Http\Requests\CMSPackageHeaderRequest;
use Modules\CMS\App\Services\CMSPackageHeaderService;

class CMSPackageHeaderController extends Controller
{
    use ResponseTrait;
    use ChecksPermissionTrait;

    public $mapActionPermission;

    /**
     * CMSPackageHeaderController constructor
     *
     */
    public function __construct(
        private CMSPackageHeaderService $cmsPackageHeaderService,
        private ArticleService $articleService,
        private ArticleDataService $articleDataService,
        private ArticleLangDataService $articleLangDataService,
        private LanguageService $languageService,
    ) {
        $this->mapActionPermission = [
            'edit'           => PermissionMenuEnum::CMS_PACKAGE_BANNER->value . '.' . PermissionActionEnum::READ->value,
            'getArticleLang' => PermissionMenuEnum::CMS_PACKAGE_BANNER->value . '.' . PermissionActionEnum::READ->value,
            'update'         => PermissionMenuEnum::CMS_PACKAGE_BANNER->value . '.' . PermissionActionEnum::READ->value,
        ];
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
            'message' => localize("Package Header Data"),
            'title'   => localize("Package Header"),
            'data'    => $data,
        ]);
    }

    /**
     * Get Article Data Lang Data for Package Header the specified resource.
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
            'message' => localize("Package Header language Data"),
            'title'   => localize("Package Header language "),
            'data'    => $articleLangData,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CMSPackageHeaderRequest  $request
     * @param  int  $articleId
     * @return RedirectResponse
     * @throws Exception
     */
    public function update(CMSPackageHeaderRequest $request, int $articleId): JsonResponse
    {
        $data               = $request->validated();
        $data['article_id'] = $articleId;

        $article = $this->cmsPackageHeaderService->update($data);

        return response()->json([
            'success' => true,
            'message' => localize("Package Header update successfully"),
            'title'   => localize("Package Header"),
            'data'    => $article,
        ]);
    }

}
