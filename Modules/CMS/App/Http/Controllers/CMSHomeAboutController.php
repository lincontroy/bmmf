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
use Modules\CMS\App\Http\Requests\CMSHomeAboutRequest;
use Modules\CMS\App\Services\CMSHomeAboutService;
use Modules\CMS\DataTables\HomeAboutTable;

class CMSHomeAboutController extends Controller
{
    use ResponseTrait;
    use ChecksPermissionTrait;

    public $mapActionPermission;

    /**
     * CMSHomeAboutController constructor
     *
     */
    public function __construct(
        private CMSHomeAboutService $cmsHomeAboutService,
        private ArticleService $articleService,
        private ArticleDataService $articleDataService,
        private ArticleLangDataService $articleLangDataService,
        private LanguageService $languageService,
    ) {
        $this->mapActionPermission = [
            'index'          => PermissionMenuEnum::CMS_HOME_ABOUT->value . '.' . PermissionActionEnum::READ->value,
            'edit'           => PermissionMenuEnum::CMS_HOME_ABOUT->value . '.' . PermissionActionEnum::READ->value,
            'getArticleLang' => PermissionMenuEnum::CMS_HOME_ABOUT->value . '.' . PermissionActionEnum::READ->value,
            'update'         => PermissionMenuEnum::CMS_HOME_ABOUT->value . '.' . PermissionActionEnum::READ->value,
        ];
    }

    /**
     * Index
     *
     */
    public function index(HomeAboutTable $dataTable)
    {
        cs_set('theme', [
            'title'       => localize('Home About'),
            'description' => localize('Home About'),
        ]);

        $languages = $this->languageService->activeLanguages();
        return $dataTable->render('cms::home-about.index', compact('languages'));
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
            'message' => localize("Home About Data"),
            'title'   => localize("Home About"),
            'data'    => $data,
        ]);
    }

    /**
     * Get Article Data Lang Data for Home About the specified resource.
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
            'message' => localize("Home About language Data"),
            'title'   => localize("Home About language "),
            'data'    => $articleLangData,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CMSHomeAboutRequest  $request
     * @param  int  $articleId
     * @return RedirectResponse
     * @throws Exception
     */
    public function update(CMSHomeAboutRequest $request, int $articleId): JsonResponse
    {
        $data               = $request->validated();
        $data['article_id'] = $articleId;

        $article = $this->cmsHomeAboutService->update($data);

        return response()->json([
            'success' => true,
            'message' => localize("Home About update successfully"),
            'title'   => localize("Home About"),
            'data'    => $article,
        ]);
    }

}
