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

class CMSPaymentWeAcceptController extends Controller
{
    use ResponseTrait;
    use ChecksPermissionTrait;

    public $mapActionPermission;

    /**
     * CMSPaymentWeAcceptController constructor
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
            'index' => PermissionMenuEnum::CMS_PAYMENT_WE_ACCEPT->value . '.' . PermissionActionEnum::READ->value,
        ];
    }

    /**
     * Index
     *
     */
    public function index()
    {
        cs_set('theme', [
            'title'       => localize('Payment We Accept'),
            'description' => localize('Payment We Accept'),
        ]);

        $languages       = $this->languageService->activeLanguages();
        $paymentWeAccept = $this->articleService->paymentWeAccept();

        return view('cms::payment-we-accept.index', compact('languages', 'paymentWeAccept'));
    }

}
