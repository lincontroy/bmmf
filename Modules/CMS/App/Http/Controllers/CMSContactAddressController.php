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
use Modules\CMS\App\Http\Requests\CMSContactAddressRequest;
use Modules\CMS\App\Services\CMSContactAddressService;
use Modules\CMS\DataTables\ContactAddressTable;

class CMSContactAddressController extends Controller
{
    use ResponseTrait;
    use ChecksPermissionTrait;

    public $mapActionPermission;

    /**
     * CMSContactAddressController constructor
     *
     */
    public function __construct(
        private CMSContactAddressService $contactAddressService,
        private ArticleService $articleService,
        private ArticleLangDataService $articleLangDataService,
        private LanguageService $languageService,
    ) {
        $this->mapActionPermission = [
            'index'          => PermissionMenuEnum::CMS_CONTACT->value . '.' . PermissionActionEnum::READ->value,
            'store'          => PermissionMenuEnum::CMS_CONTACT->value . '.' . PermissionActionEnum::READ->value,
            'edit'           => PermissionMenuEnum::CMS_CONTACT->value . '.' . PermissionActionEnum::READ->value,
            'getArticleLang' => PermissionMenuEnum::CMS_CONTACT->value . '.' . PermissionActionEnum::READ->value,
            'update'         => PermissionMenuEnum::CMS_CONTACT->value . '.' . PermissionActionEnum::READ->value,
            'destroy'        => PermissionMenuEnum::CMS_CONTACT->value . '.' . PermissionActionEnum::READ->value,
        ];
    }

    /**
     * Index
     *
     */
    public function index(ContactAddressTable $dataTable)
    {
        cs_set('theme', [
            'title'       => localize('Contact Address'),
            'description' => localize('Contact Address'),
        ]);

        $languages            = $this->languageService->activeLanguages();

        return $dataTable->render('cms::contact.address.index', compact('languages'));
    }

    /**
     * Store the specified resource in storage.
     *
     * @param  CMSContactAddressRequest  $request
     * @return JsonResponse
     * @throws Exception
     */
    public function store(CMSContactAddressRequest $request): JsonResponse
    {
        $data = $request->validated();

        $article = $this->contactAddressService->create($data);

        return response()->json([
            'success' => true,
            'message' => localize("Contact Address create successfully"),
            'title'   => localize("Contact Address"),
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
            'message' => localize("Contact Address Data"),
            'title'   => localize("Contact Address"),
            'data'    => $data,
        ]);
    }

    /**
     * Get Article Data Lang Data for Blog the specified resource.
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
            'message' => localize("Contact Address language Data"),
            'title'   => localize("Contact Address language "),
            'data'    => $articleLangData,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CMSContactAddressRequest  $request
     * @param  int  $articleId
     * @return RedirectResponse
     * @throws Exception
     */
    public function update(CMSContactAddressRequest $request, int $articleId): JsonResponse
    {
        $data               = $request->validated();
        $data['article_id'] = $articleId;

        $article = $this->contactAddressService->update($data);

        return response()->json([
            'success' => true,
            'message' => localize("Contact Address update successfully"),
            'title'   => localize("Contact Address"),
            'data'    => $article,
        ]);
    }

    /**
     * Remove the specified resource in storage.
     *
     * @param  int  $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(int $id): JsonResponse
    {
        $this->contactAddressService->destroy(['article_id' => $id]);

        return response()->json([
            'success' => true,
            'message' => localize("Contact Address delete successfully"),
            'title'   => localize("Contact Address"),
        ]);

    }

}
