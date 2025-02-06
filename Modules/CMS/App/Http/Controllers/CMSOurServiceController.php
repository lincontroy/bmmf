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
use Modules\CMS\DataTables\OurServiceTable;

class CMSOurServiceController extends Controller
{
    use ResponseTrait;
    use ChecksPermissionTrait;

    public $mapActionPermission;

    /**
     * CMSOurServiceController constructor
     *
     */
    public function __construct(
        private ArticleService $articleService,
        private ArticleDataService $articleDataService,
        private ArticleLangDataService $articleLangDataService,
        private LanguageService $languageService,
    ) {
        $this->mapActionPermission = [
            'index' => PermissionMenuEnum::CMS_OUR_SERVICE->value . '.' . PermissionActionEnum::READ->value,
        ];
    }

    /**
     * Index
     *
     */
    public function index(OurServiceTable $dataTable)
    {
        cs_set('theme', [
            'title'       => localize('Our Service'),
            'description' => localize('Our Service'),
        ]);

        $languages        = $this->languageService->activeLanguages();
        $ourServiceHeader = $this->articleService->ourServiceHeader();
        $serviceTopBanner = $this->articleService->serviceTopBanner();

        return $dataTable->render('cms::our-service.index', compact('languages', 'ourServiceHeader', 'serviceTopBanner'));
    }

}
