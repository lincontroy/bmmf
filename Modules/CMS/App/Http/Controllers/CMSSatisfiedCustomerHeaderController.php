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
use Modules\CMS\App\Http\Requests\CMSSatisfiedCustomerHeaderRequest;
use Modules\CMS\App\Services\CMSCustomerSatisfyContentService;
use Modules\CMS\App\Services\CMSSatisfiedCustomerHeaderService;

class CMSSatisfiedCustomerHeaderController extends Controller
{
    use ResponseTrait;
    use ChecksPermissionTrait;

    public $mapActionPermission;

    /**
     * CMSSatisfiedCustomerHeaderController constructor
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
            'edit'           => PermissionMenuEnum::CMS_SATISFIED_CUSTOMER->value . '.' . PermissionActionEnum::READ->value,
            'update'         => PermissionMenuEnum::CMS_SATISFIED_CUSTOMER->value . '.' . PermissionActionEnum::READ->value,
            'getArticleLang' => PermissionMenuEnum::CMS_SATISFIED_CUSTOMER->value . '.' . PermissionActionEnum::READ->value,
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
            'message' => localize("Satisfy Customer Header Data"),
            'title'   => localize("Satisfy Customer Header"),
            'data'    => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CMSSatisfiedCustomerHeaderRequest  $request
     * @param  int  $languageId
     * @return RedirectResponse
     * @throws Exception
     */
    public function update(CMSSatisfiedCustomerHeaderRequest $request, int $articleId): JsonResponse
    {
        $data               = $request->validated();
        $data['article_id'] = $articleId;

        $article = $this->cmsSatisfiedCustomerHeaderService->update($data);

        return response()->json([
            'success' => true,
            'message' => localize("Satisfy Customer Header update successfully"),
            'title'   => localize("Satisfy Customer Header"),
            'data'    => $article,
        ]);
    }

    /**
     * Get Article Data Lang Data for Satisfy Customer header the specified resource.
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
            'message' => localize("Satisfy Customer Header language Data"),
            'title'   => localize("Satisfy Customer Header language "),
            'data'    => $articleLangData,
        ]);
    }

}
