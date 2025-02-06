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
use Modules\CMS\App\Http\Requests\CMSQuickExchangeRequest;
use Modules\CMS\App\Services\CMSQuickExchangeService;
use Modules\CMS\DataTables\QuickExchangeTable;

class CMSQuickExchangeController extends Controller
{
    use ResponseTrait;
    use ChecksPermissionTrait;

    public $mapActionPermission;

    /**
     * CMSQuickExchangeController constructor
     *
     */
    public function __construct(
        private CMSQuickExchangeService $cmsQuickExchangeService,
        private ArticleService $articleService,
        private ArticleDataService $articleDataService,
        private ArticleLangDataService $articleLangDataService,
        private LanguageService $languageService,
    ) {
        $this->mapActionPermission = [
            'index'          => PermissionMenuEnum::CMS_QUICK_EXCHANGE->value . '.' . PermissionActionEnum::READ->value,
            'edit'           => PermissionMenuEnum::CMS_QUICK_EXCHANGE->value . '.' . PermissionActionEnum::READ->value,
            'getArticleLang' => PermissionMenuEnum::CMS_QUICK_EXCHANGE->value . '.' . PermissionActionEnum::READ->value,
            'update'         => PermissionMenuEnum::CMS_QUICK_EXCHANGE->value . '.' . PermissionActionEnum::READ->value,
        ];

    }

    /**
     * Index
     *
     */
    public function index(QuickExchangeTable $dataTable)
    {
        cs_set('theme', [
            'title'       => localize('Quick Exchange'),
            'description' => localize('Quick Exchange'),
        ]);

        $languages = $this->languageService->activeLanguages();
        return $dataTable->render('cms::quick_exchange.index', compact('languages'));
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
            'message' => localize("QuickExchange Data"),
            'title'   => localize("QuickExchange"),
            'data'    => $data,
        ]);
    }

    /**
     * Get Article Data Lang Data for Investment the specified resource.
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
            'message' => localize("QuickExchange language Data"),
            'title'   => localize("QuickExchange language "),
            'data'    => $articleLangData,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CMSQuickExchangeRequest  $request
     * @param  int  $articleId
     * @return JsonResponse
     * @throws Exception
     */
    public function update(CMSQuickExchangeRequest $request, int $articleId): JsonResponse
    {
        $data               = $request->validated();
        $data['article_id'] = $articleId;

        $article = $this->cmsQuickExchangeService->update($data);

        return response()->json([
            'success' => true,
            'message' => localize("QuickExchange update successfully"),
            'title'   => localize("QuickExchange"),
            'data'    => $article,
        ]);
    }

}
