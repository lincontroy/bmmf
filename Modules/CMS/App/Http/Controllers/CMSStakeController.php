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
use Modules\CMS\App\Services\CMSPaymentWeAcceptService;

class CMSStakeController extends Controller
{
    use ResponseTrait;
    use ChecksPermissionTrait;

    public $mapActionPermission;

    /**
     * CMSStakeController constructor
     *
     */
    public function __construct(
        private CMSPaymentWeAcceptService $cmsPaymentWeAcceptService,
        private ArticleService $articleService,
        private ArticleDataService $articleDataService,
        private ArticleLangDataService $articleLangDataService,
        private LanguageService $languageService,
    ) {
        $this->mapActionPermission = [
            'index' => PermissionMenuEnum::CMS_STAKE->value . '.' . PermissionActionEnum::READ->value,
        ];
    }

    /**
     * Index
     *
     */
    public function index()
    {
        cs_set('theme', [
            'title'       => localize('Stake'),
            'description' => localize('Stake'),
        ]);

        $languages       = $this->languageService->activeLanguages();
        $stakeBanner = $this->articleService->stakeBanner();

        return view('cms::stake.index', compact('languages', 'stakeBanner'));
    }

}
