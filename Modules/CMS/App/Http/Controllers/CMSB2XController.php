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

class CMSB2XController extends Controller
{
    use ResponseTrait;
    use ChecksPermissionTrait;

    public $mapActionPermission;

    /**
     * CMSB2XController constructor
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
            'index' => PermissionMenuEnum::CMS_B2X->value . '.' . PermissionActionEnum::READ->value,
        ];
    }

    /**
     * Index
     *
     */
    public function index()
    {
        cs_set('theme', [
            'title'       => localize('B2X'),
            'description' => localize('B2X'),
        ]);

        $languages             = $this->languageService->activeLanguages();
        $b2xLoan               = $this->articleService->b2xLoan();
        $b2xLoanBanner         = $this->articleService->b2xLoanBanner();
        $b2xCalculatorHeader   = $this->articleService->b2xCalculatorHeader();
        $b2xLoanDetailsHeader  = $this->articleService->b2xLoanDetailsHeader();
        $b2xLoanDetailsContent = $this->articleService->b2xLoanDetailsContent();

        return view('cms::b2x.index', compact('languages', 'b2xLoan', 'b2xLoanBanner', 'b2xCalculatorHeader', 'b2xLoanDetailsHeader', 'b2xLoanDetailsContent'));
    }

}
