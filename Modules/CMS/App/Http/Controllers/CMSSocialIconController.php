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
use Modules\CMS\App\Http\Requests\CMSSocialIconRequest;
use Modules\CMS\App\Services\CMSSocialIconService;
use Modules\CMS\DataTables\SocialIconTable;

class CMSSocialIconController extends Controller
{
    use ResponseTrait;
    use ChecksPermissionTrait;

    public $mapActionPermission;

    /**
     * CMSSocialIconController constructor
     *
     */
    public function __construct(
        private CMSSocialIconService $cmsSocialIconService,
        private ArticleService $articleService,
        private ArticleDataService $articleDataService,
        private ArticleLangDataService $articleLangDataService,
        private LanguageService $languageService,
    ) {
        $this->mapActionPermission = [
            'index'          => PermissionMenuEnum::CMS_SOCIAL_ICON->value . '.' . PermissionActionEnum::READ->value,
            'store'          => PermissionMenuEnum::CMS_SOCIAL_ICON->value . '.' . PermissionActionEnum::READ->value,
            'edit'           => PermissionMenuEnum::CMS_SOCIAL_ICON->value . '.' . PermissionActionEnum::READ->value,
            'getArticleLang' => PermissionMenuEnum::CMS_SOCIAL_ICON->value . '.' . PermissionActionEnum::READ->value,
            'update'         => PermissionMenuEnum::CMS_SOCIAL_ICON->value . '.' . PermissionActionEnum::READ->value,
            'destroy'        => PermissionMenuEnum::CMS_SOCIAL_ICON->value . '.' . PermissionActionEnum::READ->value,
        ];
    }

    /**
     * Index
     * @param  SocialIconTable  $dataTable
     *
     */
    public function index(SocialIconTable $dataTable)
    {
        cs_set('theme', [
            'title'       => localize('Social Icon'),
            'description' => localize('Social Icon'),
        ]);

        return $dataTable->render('cms::social-icon.index');
    }

    /**
     * Store the specified resource in storage.
     *
     * @param  CMSSocialIconRequest  $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function store(CMSSocialIconRequest $request): JsonResponse
    {
        $data = $request->validated();

        $article = $this->cmsSocialIconService->create($data);

        return response()->json([
            'success' => true,
            'message' => localize("Social Icon create successfully"),
            'title'   => localize("Social Icon"),
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
        }

        return response()->json([
            'success' => true,
            'message' => localize("Home slider Data"),
            'title'   => localize("Home slider"),
            'data'    => $data,
        ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  CMSSocialIconRequest  $request
     * @param  int  $articleId
     * @return RedirectResponse
     * @throws Exception
     */
    public function update(CMSSocialIconRequest $request, int $articleId): JsonResponse
    {
        $data               = $request->validated();
        $data['article_id'] = $articleId;

        $article = $this->cmsSocialIconService->update($data);

        return response()->json([
            'success' => true,
            'message' => localize("Social Icon update successfully"),
            'title'   => localize("Social Icon"),
            'data'    => $article,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $articleId
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(int $articleId)
    {
        $this->cmsSocialIconService->destroy(['article_id' => $articleId]);

        return response()->json([
            'success' => true,
            'message' => localize("Home slider delete successfully"),
            'title'   => localize("Home slider"),
        ]);

    }

}
