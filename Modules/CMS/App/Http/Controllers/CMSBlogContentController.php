<?php

namespace Modules\CMS\App\Http\Controllers;

use App\Enums\PermissionActionEnum;
use App\Enums\PermissionMenuEnum;
use App\Http\Controllers\Controller;
use App\Services\ArticleLangDataService;
use App\Services\ArticleService;
use App\Services\LanguageService;
use App\Traits\ChecksPermissionTrait;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Modules\CMS\App\Http\Requests\CMSBlogRequest;
use Modules\CMS\App\Services\CMSBlogContentService;

class CMSBlogContentController extends Controller
{
    use ResponseTrait;
    use ChecksPermissionTrait;

    public $mapActionPermission;

    /**
     * CMSBlogContentController constructor
     *
     */
    public function __construct(
        private CMSBlogContentService $blogContentService,
        private ArticleService $articleService,
        private ArticleLangDataService $articleLangDataService,
        private LanguageService $languageService,
    ) {
        $this->mapActionPermission = [
            'store'          => PermissionMenuEnum::CMS_BLOG->value . '.' . PermissionActionEnum::READ->value,
            'edit'           => PermissionMenuEnum::CMS_BLOG->value . '.' . PermissionActionEnum::READ->value,
            'getArticleLang' => PermissionMenuEnum::CMS_BLOG->value . '.' . PermissionActionEnum::READ->value,
            'update'         => PermissionMenuEnum::CMS_BLOG->value . '.' . PermissionActionEnum::READ->value,
            'destroy'        => PermissionMenuEnum::CMS_BLOG->value . '.' . PermissionActionEnum::READ->value,
        ];
    }

    /**
     * Store the specified resource in storage.
     *
     * @param  BlogRequest  $request
     * @return JsonResponse
     * @throws Exception
     */
    public function store(CMSBlogRequest $request): JsonResponse
    {
        $data = $request->validated();

        $article = $this->blogContentService->create($data);

        return response()->json([
            'success' => true,
            'message' => localize("Blog Content create successfully"),
            'title'   => localize("Blog Content"),
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
            $data['articleLangData'] = $this->articleLangDataService->all(['article_id' => $article->id, 'language_id' => $defaultLanguage->id]);
        }

        return response()->json([
            'success' => true,
            'message' => localize("Blog Content Data"),
            'title'   => localize("Blog Content"),
            'data'    => $data,
        ]);
    }

    /**
     * Get Article Data Lang Data for Blog the specified resource.
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
            'message' => localize("Blog Content language Data"),
            'title'   => localize("Blog Content language "),
            'data'    => $articleLangData,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CMSBlogRequest  $request
     * @param  int  $articleId
     * @return RedirectResponse
     * @throws Exception
     */
    public function update(CMSBlogRequest $request, int $articleId): JsonResponse
    {
        $data               = $request->validated();
        $data['article_id'] = $articleId;

        $article = $this->blogContentService->update($data);

        return response()->json([
            'success' => true,
            'message' => localize("Blog Content update successfully"),
            'title'   => localize("Blog Content"),
            'data'    => $article,
        ]);
    }

    /**
     * Remove the specified resource in storage.
     *
     * @param  int  $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(int $id): JsonResponse
    {
        $this->blogContentService->destroy(['article_id' => $id]);

        return response()->json([
            'success' => true,
            'message' => localize("Blog Content delete successfully"),
            'title'   => localize("Blog Content"),
        ]);

    }

}
