<?php

namespace Modules\Package\App\Http\Controllers\Api;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Package\App\Services\PackageService;
use Symfony\Component\HttpFoundation\Response;

class PackageController extends Controller
{
    use ResponseTrait;

    /**
     * WebsiteController constructor
     *
     */
    public function __construct(
        private PackageService $packageService,
    ) {

    }

    /**
     * Fetch package
     * @return \Illuminate\Http\JsonResponse
     */
    public function packages(Request $request): JsonResponse
    {
        $languageId = app()->make('language_id');
        $bannerData = $this->packageService->findManyArticles('package_banner', $languageId);
        $packages   = $this->packageService->findPackages($request->input('page_no', 1));

        $packageData = (object) [
            "package_banner" => $this->formateResponse($bannerData),
            "packages"       => $packages,
            'totalDataRows'  => $packages->total(),
        ];

        return $this->sendJsonResponse(
            'package',
            StatusEnum::SUCCESS->value,
            Response::HTTP_OK,
            '',
            $packageData
        );
    }

    /**
     * Fetch all active packages
     * @return \Illuminate\Http\JsonResponse
     */
    public function homePackage(Request $request): JsonResponse
    {
        $languageId = app()->make('language_id');
        $headerData = $this->packageService->findLangArticle('package_header', $languageId);
        $packages   = $this->packageService->findPackages($request->input('page_no', 1));

        return $this->sendJsonResponse(
            'packages',
            StatusEnum::SUCCESS->value,
            Response::HTTP_OK,
            '',
            (object) [
                "package_header" => $this->formateResponse($headerData),
                "package_body"   => $packages,
                "totalDataRows"  => $packages->total(),
            ]
        );
    }
}
