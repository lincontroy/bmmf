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
use Modules\CMS\App\Http\Requests\CMSCustomerSatisfyContentRequest;
use Modules\CMS\App\Services\CMSCustomerSatisfyContentService;
use Modules\CMS\App\Services\CMSSatisfiedCustomerHeaderService;
use Modules\CMS\DataTables\CustomerSatisfyContentTable;

class CMSSatisfiedCustomerController extends Controller
{
    use ResponseTrait;
    use ChecksPermissionTrait;

    public $mapActionPermission;
    /**
     * CMSSatisfiedCustomerController constructor
     *
     */
    public function __construct(
        private CMSSatisfiedCustomerHeaderService $cmsSatisfiedCustomerHeaderService,
        private CMSCustomerSatisfyContentService $cmsCustomerSatisfyContentService,
        private ArticleService $articleService,
        private ArticleDataService $articleDataService,
        private ArticleLangDataService $articleLangDataService,
        private LanguageService $languageService,
    ) {
        $this->mapActionPermission = [
            'index'          => PermissionMenuEnum::CMS_SATISFIED_CUSTOMER->value . '.' . PermissionActionEnum::READ->value,
            'store'          => PermissionMenuEnum::CMS_SATISFIED_CUSTOMER->value . '.' . PermissionActionEnum::READ->value,
            'edit'           => PermissionMenuEnum::CMS_SATISFIED_CUSTOMER->value . '.' . PermissionActionEnum::READ->value,
            'getArticleLang' => PermissionMenuEnum::CMS_SATISFIED_CUSTOMER->value . '.' . PermissionActionEnum::READ->value,
            'update'         => PermissionMenuEnum::CMS_SATISFIED_CUSTOMER->value . '.' . PermissionActionEnum::READ->value,
            'destroy'        => PermissionMenuEnum::CMS_SATISFIED_CUSTOMER->value . '.' . PermissionActionEnum::READ->value,
        ];
    }

    /**
     * Index
     *
     */
    public function index(CustomerSatisfyContentTable $dataTable)
    {
        cs_set('theme', [
            'title'       => localize('Satisfied Customer'),
            'description' => localize('Satisfied Customer'),
        ]);

        $languages = $this->languageService->activeLanguages();
        $article   = $this->articleService->satisfiedCustomerHeader();

        return $dataTable->render('cms::satisfied-customer.index', compact('languages', 'article'));
    }

    /**
     * Store the specified resource in storage.
     *
     * @param  CMSCustomerSatisfyContentRequest  $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function store(CMSCustomerSatisfyContentRequest $request): JsonResponse
    {
        $data = $request->validated();

        $article = $this->cmsCustomerSatisfyContentService->create($data);

        return response()->json([
            'success' => true,
            'message' => localize("Customer Satisfy Content create successfully"),
            'title'   => localize("Customer Satisfy Content"),
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
            'message' => localize("Customer Satisfy Content Data"),
            'title'   => localize("Customer Satisfy Content"),
            'data'    => $data,
        ]);
    }

    /**
     * Get Article Data Lang Data for Customer satisfy content the specified resource.
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
            'message' => localize("Customer Satisfy Content language Data"),
            'title'   => localize("Customer Satisfy Content language "),
            'data'    => $articleLangData,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CMSCustomerSatisfyContentRequest  $request
     * @param  int  $languageId
     * @return RedirectResponse
     * @throws Exception
     */
    public function update(CMSCustomerSatisfyContentRequest $request, int $articleId): JsonResponse
    {
        $data               = $request->validated();
        $data['article_id'] = $articleId;

        $article = $this->cmsCustomerSatisfyContentService->update($data);

        return response()->json([
            'success' => true,
            'message' => localize("Customer Satisfy Content update successfully"),
            'title'   => localize("Customer Satisfy Content"),
            'data'    => $article,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $this->cmsCustomerSatisfyContentService->destroy(['article_id' => $id]);

        return response()->json([
            'success' => true,
            'message' => localize("Customer Satisfy Content delete successfully"),
            'title'   => localize("Customer Satisfy Content"),
        ]);

    }

}
