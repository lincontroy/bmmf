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
use Modules\CMS\App\Services\CMSB2XLoanBannerService;
use Modules\CMS\App\Services\CMSB2XLoanService;

class CMSTopInvestorController extends Controller
{
    use ResponseTrait;
    use ChecksPermissionTrait;

    public $mapActionPermission;

    /**
     * CMSTopInvestorController constructor
     *
     */
    public function __construct(
        private CMSB2XLoanService $cmsB2XLoanService,
        private CMSB2XLoanBannerService $cmsB2XLoanBannerService,
        private ArticleService $articleService,
        private ArticleDataService $articleDataService,
        private ArticleLangDataService $articleLangDataService,
        private LanguageService $languageService,
    ) {
        $this->mapActionPermission = [
            'index' => PermissionMenuEnum::CMS_TOP_INVESTOR->value . '.' . PermissionActionEnum::READ->value,
        ];
    }

    /**
     * Index
     *
     */
    public function index()
    {
        cs_set('theme', [
            'title'       => localize('Top Investor'),
            'description' => localize('Top Investor'),
        ]);

        $languages            = $this->languageService->activeLanguages();
        $topInvestorBanner    = $this->articleService->topInvestorBanner();
        $topInvestorTopBanner = $this->articleService->topInvestorTopBanner();
        $topInvestorHeader    = $this->articleService->topInvestorHeader();

        return view('cms::top-investor.index', compact('languages', 'topInvestorBanner', 'topInvestorTopBanner', 'topInvestorHeader'));
    }

}
