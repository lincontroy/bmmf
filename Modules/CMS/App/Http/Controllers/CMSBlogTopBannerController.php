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
use Modules\CMS\App\Http\Requests\CMSBlogTopBannerRequest;
use Modules\CMS\App\Services\CMSBlogTopBannerService;

class CMSBlogTopBannerController extends Controller
{
    use ResponseTrait;
    use ChecksPermissionTrait;

    public $mapActionPermission;

    /**
     * CMSBlogTopBannerController constructor
     *
     */
    public function __construct(
        private CMSBlogTopBannerService $cmsBlogTopBannerService,
        private ArticleService $articleService,
        private ArticleDataService $articleDataService,
        private ArticleLangDataService $articleLangDataService,
        private LanguageService $languageService,
    ) {
        $this->mapActionPermission = [
            'edit'           => PermissionMenuEnum::CMS_BLOG->value . '.' . PermissionActionEnum::READ->value,
            'update'         => PermissionMenuEnum::CMS_BLOG->value . '.' . PermissionActionEnum::READ->value,
            'getArticleLang' => PermissionMenuEnum::CMS_BLOG->value . '.' . PermissionActionEnum::READ->value,
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
            'message' => localize("Blog details top banner article Data"),
            'title'   => localize("Blog details top banner article"),
            'data'    => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CMSBlogTopBannerRequest  $request
     * @param  int  $languageId
     * @return RedirectResponse
     * @throws Exception
     */
    public function update(CMSBlogTopBannerRequest $request, int $articleId): JsonResponse
    {
        $data               = $request->validated();
        $data['article_id'] = $articleId;

        $article = $this->cmsBlogTopBannerService->update($data);

        return response()->json([
            'success' => true,
            'message' => localize("Blog top banner article update successfully"),
            'title'   => localize("Blog top banner article"),
            'data'    => $article,
        ]);
    }

    /**
     * Get Article Data Lang Data for Blog top banner the specified resource.
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
            'message' => localize("Blog top banner article language Data"),
            'title'   => localize("Blog top banner article language "),
            'data'    => $articleLangData,
        ]);
    }

}
