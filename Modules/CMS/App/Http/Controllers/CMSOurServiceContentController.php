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
use Modules\CMS\App\Http\Requests\CMSOurServiceContentRequest;
use Modules\CMS\App\Services\CMSOurServiceContentService;

class CMSOurServiceContentController extends Controller
{
    use ResponseTrait;
    use ChecksPermissionTrait;

    public $mapActionPermission;

    /**
     * CMSOurServiceContentController constructor
     *
     */
    public function __construct(
        private CMSOurServiceContentService $cmsOurServiceContentService,
        private ArticleService $articleService,
        private ArticleDataService $articleDataService,
        private ArticleLangDataService $articleLangDataService,
        private LanguageService $languageService,
    ) {
        $this->mapActionPermission = [
            'store'              => PermissionMenuEnum::CMS_OUR_SERVICE->value . '.' . PermissionActionEnum::READ->value,
            'edit'               => PermissionMenuEnum::CMS_OUR_SERVICE->value . '.' . PermissionActionEnum::READ->value,
            'update'             => PermissionMenuEnum::CMS_OUR_SERVICE->value . '.' . PermissionActionEnum::READ->value,
            'destroy'            => PermissionMenuEnum::CMS_OUR_SERVICE->value . '.' . PermissionActionEnum::READ->value,
            'getArticleDataLang' => PermissionMenuEnum::CMS_OUR_SERVICE->value . '.' . PermissionActionEnum::READ->value,
        ];
    }

    /**
     * Store the specified resource in storage.
     *
     * @param  CMSOurServiceContentRequest  $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function store(CMSOurServiceContentRequest $request): JsonResponse
    {
        $data = $request->validated();

        $article = $this->cmsOurServiceContentService->create($data);

        return response()->json([
            'success' => true,
            'message' => localize("Our Service Content create successfully"),
            'title'   => localize("Our Service Content"),
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
            'message' => localize("Our Service Content Data"),
            'title'   => localize("Our Service Content"),
            'data'    => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CMSOurServiceContentRequest  $request
     * @param  int  $languageId
     * @return RedirectResponse
     * @throws Exception
     */
    public function update(CMSOurServiceContentRequest $request, int $articleId): JsonResponse
    {
        $data               = $request->validated();
        $data['article_id'] = $articleId;

        $article = $this->cmsOurServiceContentService->update($data);

        return response()->json([
            'success' => true,
            'message' => localize("Our Service Content update successfully"),
            'title'   => localize("Our Service Content"),
            'data'    => $article,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $this->cmsOurServiceContentService->destroy(['article_id' => $id]);

        return response()->json([
            'success' => true,
            'message' => localize("Our Service content delete successfully"),
            'title'   => localize("Our Service content"),
        ]);

    }

    /**
     * Get Our Service Content the specified resource.
     *
     * @param  int  $languageId
     * @param  int  $articleId
     * @return JsonResponse
     * @throws Exception
     */
    public function getArticleDataLang(int $languageId, int $articleId): JsonResponse
    {
        $articleLangData = $this->articleLangDataService->all(['article_id' => $articleId, 'language_id' => $languageId]);

        return response()->json([
            'success' => true,
            'message' => localize("Our Service Content Data"),
            'title'   => localize("Our Service Content"),
            'data'    => $articleLangData,
        ]);
    }

}
