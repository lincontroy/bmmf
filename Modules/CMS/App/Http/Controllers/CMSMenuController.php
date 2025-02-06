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
use Modules\CMS\App\Http\Requests\CMSMenuRequest;
use Modules\CMS\App\Services\CMSMenuService;
use Modules\CMS\DataTables\HeaderFooterMenuTable;

class CMSMenuController extends Controller
{
    use ResponseTrait;
    use ChecksPermissionTrait;

    public $mapActionPermission;

    /**
     * CMSMenuController constructor
     *
     */
    public function __construct(
        private CMSMenuService $cmsMenuService,
        private ArticleService $articleService,
        private ArticleLangDataService $articleLangDataService,
        private LanguageService $languageService,
    ) {
        $this->mapActionPermission = [
            'index'          => PermissionMenuEnum::CMS_MENU->value . '.' . PermissionActionEnum::READ->value,
            'edit'           => PermissionMenuEnum::CMS_MENU->value . '.' . PermissionActionEnum::READ->value,
            'getArticleLang' => PermissionMenuEnum::CMS_MENU->value . '.' . PermissionActionEnum::READ->value,
            'update'         => PermissionMenuEnum::CMS_MENU->value . '.' . PermissionActionEnum::READ->value,
        ];
    }

    /**
     * Index
     *
     */
    public function index(HeaderFooterMenuTable $dataTable)
    {
        cs_set('theme', [
            'title'       => localize('Menu'),
            'description' => localize('Menu'),
        ]);

        $languages = $this->languageService->activeLanguages();
        return $dataTable->render('cms::menu.index', compact('languages'));
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

        $data              = [];
        $data['article']   = $article;
        $data['languages'] = $languages;
        $defaultLanguage   = $languages->keyBy('symbol')[app()->getLocale()] ?? null;

        if ($article && $defaultLanguage) {
            $data['articleLangData'] = $this->articleLangDataService->all(['article_id' => $article->id, 'language_id' => $defaultLanguage->id]);
        }

        return response()->json([
            'success' => true,
            'message' => localize("Menu Data"),
            'title'   => localize("Menu"),
            'data'    => $data,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $languageId
     * @param  string  $menuName
     * @return JsonResponse
     * @throws Exception
     */
    public function getArticleLang(int $languageId, string $menuName): JsonResponse
    {

        if ($menuName == 'home') {
            $menuName = '/';
        }

        $articleLangData = $this->articleLangDataService->first(['slug' => $menuName, 'language_id' => $languageId]);

        if (!$articleLangData) {

            if ($menuName == '/') {
                $menuName = 'home';
            }

            $language = $this->languageService->findOrFail($languageId);

            if ($language) {
                $localizeMenuName = localize($menuName, null, $language->symbol);
            }

        } else {
            $localizeMenuName = $articleLangData->small_content;
        }

        return response()->json([
            'success' => true,
            'message' => localize("Menu language Data"),
            'title'   => localize("Menu language "),
            'data'    => $localizeMenuName,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CMSMenuRequest  $request
     * @param  int  $articleId
     * @return RedirectResponse
     * @throws Exception
     */
    public function update(CMSMenuRequest $request, int $articleId): JsonResponse
    {
        $data               = $request->validated();
        $data['article_id'] = $articleId;

        $article = $this->cmsMenuService->update($data);

        return response()->json([
            'success' => true,
            'message' => localize("Menu update successfully"),
            'title'   => localize("Menu"),
            'data'    => $article,
        ]);
    }

}
