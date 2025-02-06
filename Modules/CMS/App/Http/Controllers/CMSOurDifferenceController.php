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
use Modules\CMS\DataTables\OurDifferenceContentTable;

class CMSOurDifferenceController extends Controller
{
    use ResponseTrait;
    use ChecksPermissionTrait;

    public $mapActionPermission;

    /**
     * CMSOurDifferenceController constructor
     *
     */
    public function __construct(
        private ArticleService $articleService,
        private ArticleDataService $articleDataService,
        private ArticleLangDataService $articleLangDataService,
        private LanguageService $languageService,
    ) {
        $this->mapActionPermission = [
            'index' => PermissionMenuEnum::CMS_OUR_DIFFERENCE->value . '.' . PermissionActionEnum::READ->value,
        ];
    }

    /**
     * Index
     *
     */
    public function index(OurDifferenceContentTable $dataTable)
    {
        cs_set('theme', [
            'title'       => localize('Our Difference'),
            'description' => localize('Our Difference'),
        ]);

        $languages            = $this->languageService->activeLanguages();
        $ourDifferenceHeader  = $this->articleService->ourDifferenceHeader(); 

        return $dataTable->render('cms::our-difference.index', compact('languages', 'ourDifferenceHeader'));
    }

}
