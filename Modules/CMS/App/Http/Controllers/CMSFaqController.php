<?php

namespace Modules\CMS\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ArticleDataService;
use App\Services\ArticleLangDataService;
use App\Services\ArticleService;
use App\Services\LanguageService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Modules\CMS\App\Http\Requests\CMSFaqContentRequest;
use Modules\CMS\App\Http\Requests\CMSFaqHeaderRequest;
use Modules\CMS\App\Services\CMSFaqContentService;
use Modules\CMS\App\Services\CMSFaqHeaderService;
use Modules\CMS\DataTables\FaqContentTable;
use App\Traits\ChecksPermissionTrait;
use App\Enums\PermissionMenuEnum;
use App\Enums\PermissionActionEnum;

class CMSFaqController extends Controller
{
    use ResponseTrait;
    use ChecksPermissionTrait;

    public $mapActionPermission;

    /**
     * CMSFaqController constructor
     *
     */
    public function __construct(
        private CMSFaqHeaderService $cmsFaqHeaderService,
        private CMSFaqContentService $cmsFaqContentService,
        private ArticleService $articleService,
        private ArticleDataService $articleDataService,
        private ArticleLangDataService $articleLangDataService,
        private LanguageService $languageService,
    ) {
        $this->mapActionPermission = [
            'index'          => PermissionMenuEnum::CMS_FAQ->value . '.' . PermissionActionEnum::READ->value,
            'store'          => PermissionMenuEnum::CMS_FAQ->value . '.' . PermissionActionEnum::READ->value,
            'edit'           => PermissionMenuEnum::CMS_FAQ->value . '.' . PermissionActionEnum::READ->value,
            'getArticleLang' => PermissionMenuEnum::CMS_FAQ->value . '.' . PermissionActionEnum::READ->value,
            'update'         => PermissionMenuEnum::CMS_FAQ->value . '.' . PermissionActionEnum::READ->value,
            'destroy'        => PermissionMenuEnum::CMS_FAQ->value . '.' . PermissionActionEnum::READ->value,
        ];
    }

    /**
     * Index
     *
     */
    public function index(FaqContentTable $dataTable)
    {
        cs_set('theme', [
            'title'       => localize('FAQ'),
            'description' => localize('FAQ'),
        ]);

        $languages = $this->languageService->activeLanguages();
        $article   = $this->articleService->faqHeader();

        return $dataTable->render('cms::faq.index', compact('languages', 'article'));
    }

    /**
     * Store the specified resource in storage.
     *
     * @param  CMSFaqContentRequest  $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function store(CMSFaqContentRequest $request): JsonResponse
    {
        $data = $request->validated();

        $article = $this->cmsFaqContentService->create($data);

        return response()->json([
            'success' => true,
            'message' => localize("Faq Content create successfully"),
            'title'   => localize("Faq Content"),
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
            'message' => localize("Faq Content Data"),
            'title'   => localize("Faq Content"),
            'data'    => $data,
        ]);
    }

    /**
     * Get Article Data Lang Data for Faq content the specified resource.
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
            'message' => localize("Faq Content language Data"),
            'title'   => localize("Faq Content language "),
            'data'    => $articleLangData,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CMSFaqContentRequest  $request
     * @param  int  $languageId
     * @return RedirectResponse
     * @throws Exception
     */
    public function update(CMSFaqContentRequest $request, int $articleId): JsonResponse
    {
        $data               = $request->validated();
        $data['article_id'] = $articleId;

        $article = $this->cmsFaqContentService->update($data);

        return response()->json([
            'success' => true,
            'message' => localize("Faq Content update successfully"),
            'title'   => localize("Faq Content"),
            'data'    => $article,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $this->cmsFaqContentService->destroy(['article_id' => $id]);

        return response()->json([
            'success' => true,
            'message' => localize("Faq Content delete successfully"),
            'title'   => localize("Faq Content"),
        ]);

    }

}
