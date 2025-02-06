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
use Modules\CMS\App\Services\CMSBlogTopBannerService;

class CMSContactController extends Controller
{
    use ResponseTrait;
    use ChecksPermissionTrait;

    public $mapActionPermission;

    /**
     * CMSContactController constructor
     *
     */
    public function __construct(
        private CMSBlogTopBannerService $cmsBlogTopBannerService,
        private ArticleService $articleService,
        private ArticleDataService $articleDataService,
        private ArticleLangDataService $articleLangDataService,
        private LanguageService $languageService,
    ) {
        $this->mapActionPermission = [
            'index' => PermissionMenuEnum::CMS_CONTACT->value . '.' . PermissionActionEnum::READ->value,
        ];
    }

    /**
     * Index
     *
     */
    public function index()
    {
        cs_set('theme', [
            'title'       => localize('Contact Us'),
            'description' => localize('Contact Us'),
        ]);

        $languages          = $this->languageService->activeLanguages();
        $contactUsTopBanner = $this->articleService->contactUsTopBanner();

        return view('cms::contact.index', compact('languages', 'contactUsTopBanner'));
    }

}
