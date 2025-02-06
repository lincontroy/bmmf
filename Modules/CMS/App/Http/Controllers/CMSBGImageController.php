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
use Modules\CMS\App\Http\Requests\CMSBgImageRequest;
use Modules\CMS\App\Services\CMSBgImageService;

class CMSBGImageController extends Controller
{
    use ResponseTrait;
    use ChecksPermissionTrait;

    public $mapActionPermission;

    /**
     * CMSBGImageController constructor
     *
     */
    public function __construct(
        private CMSBgImageService $cmsBgImageService,
        private ArticleService $articleService,
        private ArticleDataService $articleDataService,
        private ArticleLangDataService $articleLangDataService,
        private LanguageService $languageService,
    ) {
        $this->mapActionPermission = [
            'index'  => PermissionMenuEnum::CMS_BG_IMAGE->value . '.' . PermissionActionEnum::READ->value,
            'edit'   => PermissionMenuEnum::CMS_BG_IMAGE->value . '.' . PermissionActionEnum::READ->value,
            'update' => PermissionMenuEnum::CMS_BG_IMAGE->value . '.' . PermissionActionEnum::READ->value,
        ];
    }

    /**
     * Index
     *
     */
    public function index()
    {
        cs_set('theme', [
            'title'       => localize('Bg image'),
            'description' => localize('Bg image'),
        ]);

        $languages   = $this->languageService->activeLanguages();
        $bgEffectImg = $this->articleService->bgEffectImg();

        return view('cms::bg-effect-img.index', compact('languages', 'bgEffectImg'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $articleId
     * @param  string  $slug
     * @return JsonResponse
     * @throws Exception
     */
    public function edit(int $articleId, string $slug): JsonResponse
    {
        $articleData = $this->articleDataService->first(['article_id' => $articleId, 'slug' => $slug]);

        $data = [
            'slug'    => $articleData->slug,
            'content' => storage_asset($articleData->content),
        ];

        return response()->json([
            'success' => true,
            'message' => localize("Bg image Data"),
            'title'   => localize("Bg image"),
            'data'    => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CMSBgImageRequest  $request
     * @param  int  $articleId
     * @param  string  $slug
     * @return JsonResponse
     * @throws Exception
     */
    public function update(CMSBgImageRequest $request, int $articleId, string $slug): JsonResponse
    {
        $data               = $request->validated();
        $data['article_id'] = $articleId;
        $data['slug']       = $slug;

        $article = $this->cmsBgImageService->update($data);

        return response()->json([
            'success' => true,
            'message' => localize("Bg image update successfully"),
            'title'   => localize("Bg image"),
            'data'    => $article,
        ]);
    }

}
