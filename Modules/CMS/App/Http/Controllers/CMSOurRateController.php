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
use Modules\CMS\DataTables\OurRateTable;

class CMSOurRateController extends Controller
{
    use ResponseTrait;
    use ChecksPermissionTrait;

    public $mapActionPermission;

    /**
     * CMSOurRateController constructor
     *
     */
    public function __construct(
        private ArticleService $articleService,
        private ArticleDataService $articleDataService,
        private ArticleLangDataService $articleLangDataService,
        private LanguageService $languageService,
    ) {
        $this->mapActionPermission = [
            'index' => PermissionMenuEnum::CMS_OUR_RATE->value . '.' . PermissionActionEnum::READ->value,
        ];
    }

    /**
     * Index
     *
     */
    public function index(OurRateTable $dataTable)
    {
        cs_set('theme', [
            'title'       => localize('Our Rate'),
            'description' => localize('Our Rate'),
        ]);

        $languages     = $this->languageService->activeLanguages();
        $ourRateHeader = $this->articleService->ourRateHeader();

        return $dataTable->render('cms::our-rate.index', compact('languages', 'ourRateHeader'));
    }

}
