<?php

namespace App\Http\Controllers\Api;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\IdRequest;
use App\Services\BlogService;
use App\Services\HomeService;
use App\Services\WebsiteService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends Controller
{
    use ResponseTrait;

    /**
     * WebsiteController constructor
     *
     */
    public function __construct(
        private WebsiteService $websiteService,
        private BlogService $blogService,
        private HomeService $homeService
    ) {
    }

    /**
     * Fetch Blog us by language
     * @return \Illuminate\Http\JsonResponse
     * @param Request $request
     */
    public function blog(Request $request): JsonResponse
    {
        $languageId               = app()->make('language_id');
        $attribute['perPage']     = 10;
        $attribute['page']        = $request->input('page_no', 1);
        $attribute['slug']        = 'blog';
        $attribute['language_id'] = $languageId;

        $headerData = $this->blogService->findLangArticle('blog', $languageId);
        $bannerData = $this->homeService->findManyArticles('blog_top_banner', $languageId);
        $blogData   = $this->blogService->findPaginateArticle($attribute);

        return $this->sendJsonResponse(
            'blog',
            StatusEnum::SUCCESS->value,
            Response::HTTP_OK,
            '',
            (object) [
                'blog_banner'   => $this->formateResponse($bannerData),
                'blog_header'   => $this->formateResponse($headerData),
                'blog_body'     => $blogData,
                'totalDataRows' => $blogData->total(),
            ]
        );
    }

    /**
     * Fetch Blog us by language
     * @return \Illuminate\Http\JsonResponse
     * @param mixed $id
     */
    public function blogDetails(IdRequest $request): JsonResponse
    {
        $languageId               = app()->make('language_id');
        $id                       = $request->id;
        $attribute['article_id']  = $id;
        $attribute['slug']        = 'blog';
        $attribute['language_id'] = $languageId;

        $blogDetails                 = $this->blogService->blogDetails($attribute);
        $bannerData                  = $this->blogService->findManyArticles('blog_details_top_banner', $languageId);
        $data['blog_details_banner'] = $this->formateResponse($bannerData);

        if (!empty($blogDetails)) {
            $data['blogDetails']  = $blogDetails;
            $data['relatedBlogs'] = $this->blogService->findRelatedBlog($attribute);
        } else {
            $data['blogDetails']  = [];
            $data['relatedBlogs'] = [];
        }

        return $this->sendJsonResponse(
            'home_blogs_details',
            StatusEnum::SUCCESS->value,
            Response::HTTP_OK,
            '',
            (object) $data
        );
    }

}
