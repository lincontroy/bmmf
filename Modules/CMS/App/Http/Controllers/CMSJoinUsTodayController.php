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
use Modules\CMS\App\Http\Requests\CMSJoinUsTodayRequest;
use Modules\CMS\App\Services\CMSJoinUsTodayService;
use Modules\CMS\DataTables\JoinUsTodayTable;

class CMSJoinUsTodayController extends Controller
{
    use ResponseTrait;
    use ChecksPermissionTrait;

    public $mapActionPermission;

    /**
     * CMSJoinUsTodayController constructor
     *
     */
    public function __construct(
        private CMSJoinUsTodayService $cmsJoinUsTodayService,
        private ArticleService $articleService,
        private ArticleDataService $articleDataService,
        private ArticleLangDataService $articleLangDataService,
        private LanguageService $languageService,
    ) {
        $this->mapActionPermission = [
            'index'          => PermissionMenuEnum::CMS_JOIN_US_TODAY->value . '.' . PermissionActionEnum::READ->value,
            'edit'           => PermissionMenuEnum::CMS_JOIN_US_TODAY->value . '.' . PermissionActionEnum::READ->value,
            'getArticleLang' => PermissionMenuEnum::CMS_JOIN_US_TODAY->value . '.' . PermissionActionEnum::READ->value,
            'update'         => PermissionMenuEnum::CMS_JOIN_US_TODAY->value . '.' . PermissionActionEnum::READ->value,
        ];
    }

    /**
     * Index
     *
     */
    public function index(JoinUsTodayTable $dataTable)
    {
        cs_set('theme', [
            'title'       => localize('Join Us Today'),
            'description' => localize('Join Us Today'),
        ]);

        $languages = $this->languageService->activeLanguages();
        return $dataTable->render('cms::join-us-today.index', compact('languages'));
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
            'message' => localize("Join Us Today Data"),
            'title'   => localize("Join Us Today"),
            'data'    => $data,
        ]);
    }

    /**
     * Get Article Data Lang Data for Join Us Today the specified resource.
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
            'message' => localize("Join Us Today language Data"),
            'title'   => localize("Join Us Today language "),
            'data'    => $articleLangData,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CMSJoinUsTodayRequest  $request
     * @param  int  $articleId
     * @return RedirectResponse
     * @throws Exception
     */
    public function update(CMSJoinUsTodayRequest $request, int $articleId): JsonResponse
    {
        $data               = $request->validated();
        $data['article_id'] = $articleId;


        $article = $this->cmsJoinUsTodayService->update($data);

        return response()->json([
            'success' => true,
            'message' => localize("Join Us Today update successfully"),
            'title'   => localize("Join Us Today"),
            'data'    => $article,
        ]);
    }

}
