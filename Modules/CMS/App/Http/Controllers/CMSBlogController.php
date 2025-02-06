<?php

namespace Modules\CMS\App\Http\Controllers;

use App\Enums\PermissionActionEnum;
use App\Enums\PermissionMenuEnum;
use App\Http\Controllers\Controller;
use App\Services\ArticleService;
use App\Services\LanguageService;
use App\Traits\ChecksPermissionTrait;
use App\Traits\ResponseTrait;
use Modules\CMS\DataTables\BlogTable;

class CMSBlogController extends Controller
{
    use ResponseTrait;
    use ChecksPermissionTrait;

    public $mapActionPermission;

    /**
     * CMSBlogController constructor
     *
     */
    public function __construct(
        private ArticleService $articleService,
        private LanguageService $languageService,
    ) {
        $this->mapActionPermission = [
            'index' => PermissionMenuEnum::CMS_BLOG->value . '.' . PermissionActionEnum::READ->value,
        ];
    }

    /**
     * Index
     *
     */
    public function index(BlogTable $dataTable)
    {
        cs_set('theme', [
            'title'       => localize('Blog'),
            'description' => localize('Blog'),
        ]);

        $languages            = $this->languageService->activeLanguages();
        $blogTopBanner        = $this->articleService->blogTopBanner();
        $blogDetailsTopBanner = $this->articleService->blogDetailsTopBanner();

        return $dataTable->render('cms::blog.index', compact('languages', 'blogTopBanner', 'blogDetailsTopBanner'));
    }

}
