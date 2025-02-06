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
use Modules\CMS\App\Http\Requests\CMSMerchantContentRequest;
use Modules\CMS\App\Services\CMSMerchantContentService;
use Modules\CMS\App\Services\CMSMerchantTitleService;
use Modules\CMS\DataTables\MerchantContentTable;

class CMSMerchantController extends Controller
{
    use ResponseTrait;
    use ChecksPermissionTrait;

    public $mapActionPermission;

    /**
     * CMSMerchantController constructor
     *
     */
    public function __construct(
        private CMSMerchantTitleService $cmsMerchantTitleService,
        private CMSMerchantContentService $cmsMerchantContentService,
        private ArticleService $articleService,
        private ArticleDataService $articleDataService,
        private ArticleLangDataService $articleLangDataService,
        private LanguageService $languageService,
    ) {
        $this->mapActionPermission = [
            'index'          => PermissionMenuEnum::CMS_MERCHANT->value . '.' . PermissionActionEnum::READ->value,
            'store'          => PermissionMenuEnum::CMS_MERCHANT->value . '.' . PermissionActionEnum::READ->value,
            'edit'           => PermissionMenuEnum::CMS_MERCHANT->value . '.' . PermissionActionEnum::READ->value,
            'getArticleLang' => PermissionMenuEnum::CMS_MERCHANT->value . '.' . PermissionActionEnum::READ->value,
            'update'         => PermissionMenuEnum::CMS_MERCHANT->value . '.' . PermissionActionEnum::READ->value,
            'destroy'        => PermissionMenuEnum::CMS_MERCHANT->value . '.' . PermissionActionEnum::READ->value,
        ];
    }

    /**
     * Index
     *
     */
    public function index(MerchantContentTable $dataTable)
    {
        cs_set('theme', [
            'title'       => localize('Merchant Content'),
            'description' => localize('Merchant Content'),
        ]);

        $languages = $this->languageService->activeLanguages();
        $article   = $this->articleService->merchantTitle();
        $topBanner = $this->articleService->merchantTopBanner();


        return $dataTable->render('cms::merchant.index', compact('languages', 'article', 'topBanner'));
    }

    /**
     * Store the specified resource in storage.
     *
     * @param  CMSMerchantContentRequest  $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function store(CMSMerchantContentRequest $request): JsonResponse
    {
        $data = $request->validated();

        $article = $this->cmsMerchantContentService->create($data);

        return response()->json([
            'success' => true,
            'message' => localize("Merchant Content create successfully"),
            'title'   => localize("Merchant Content"),
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
            'message' => localize("Merchant Content Data"),
            'title'   => localize("Merchant Content"),
            'data'    => $data,
        ]);
    }

    /**
     * Get Article Data Lang Data for Merchant content the specified resource.
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
            'message' => localize("Merchant Content language Data"),
            'title'   => localize("Merchant Content language "),
            'data'    => $articleLangData,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CMSMerchantContentRequest  $request
     * @param  int  $languageId
     * @return RedirectResponse
     * @throws Exception
     */
    public function update(CMSMerchantContentRequest $request, int $articleId): JsonResponse
    {
        $data               = $request->validated();
        $data['article_id'] = $articleId;

        $article = $this->cmsMerchantContentService->update($data);

        return response()->json([
            'success' => true,
            'message' => localize("Merchant Content update successfully"),
            'title'   => localize("Merchant Content"),
            'data'    => $article,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $this->cmsMerchantContentService->destroy(['article_id' => $id]);

        return response()->json([
            'success' => true,
            'message' => localize("Merchant Content delete successfully"),
            'title'   => localize("Merchant Content"),
        ]);

    }

}
