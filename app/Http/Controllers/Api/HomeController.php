<?php

namespace App\Http\Controllers\Api;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Http\Requests\IdRequest;
use App\Services\CustomerService;
use App\Services\HomeService;
use App\Services\WebsiteService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    use ResponseTrait;

    /**
     * WebsiteController constructor
     *
     */
    public function __construct(
        private WebsiteService $websiteService,
        private HomeService $homeService,
        private CustomerService $customerService,
    ) {

    }

    /**
     * Fetch all top menu by language
     * @return \Illuminate\Http\JsonResponse
     */
    public function menus(): JsonResponse
    {
        return $this->sendJsonResponse(
            'top_menu',
            StatusEnum::SUCCESS->value,
            Response::HTTP_OK,
            '',
            $this->homeService->findTopHeaderMenu('header_menu', app()->make('language_id'))
        );
    }

    /**
     * Fetch all footer menu by language
     * @return \Illuminate\Http\JsonResponse
     */
    public function footerMenus(): JsonResponse
    {
        return $this->sendJsonResponse(
            'footer_menu',
            StatusEnum::SUCCESS->value,
            Response::HTTP_OK,
            '',
            $this->homeService->findTopHeaderMenu('footer_menu', app()->make('language_id'))
        );
    }

    /**
     * Fetch slider by language
     * @return \Illuminate\Http\JsonResponse
     */
    public function homeSlider(): JsonResponse
    {
        return $this->sendJsonResponse(
            'home_slider',
            StatusEnum::SUCCESS->value,
            Response::HTTP_OK,
            '',
            $this->homeService->findManyArticles('home_slider', app()->make('language_id'))
        );
    }

    /**
     * Fetch merchant data by language
     * @return \Illuminate\Http\JsonResponse
     */
    public function homeMerchant(): JsonResponse
    {
        $languageId = app()->make('language_id');
        $headerData = $this->homeService->findLangArticle('merchant_title', $languageId);

        return $this->sendJsonResponse(
            'merchant_data',
            StatusEnum::SUCCESS->value,
            Response::HTTP_OK,
            '',
            (object) [
                'merchant_header' => $this->formateResponse($headerData),
                'merchant_body'   => $this->homeService->findManyArticles('merchant_content', $languageId),
            ]
        );
    }

    /**
     * Fetch merchant data by language
     * @return \Illuminate\Http\JsonResponse
     */
    public function merchant(): JsonResponse
    {
        $languageId = app()->make('language_id');
        $headerData = $this->homeService->findManyArticles('merchant_top_banner', $languageId);

        return $this->sendJsonResponse(
            'merchant_data',
            StatusEnum::SUCCESS->value,
            Response::HTTP_OK,
            '',
            (object) [
                'merchant_banner' => $this->formateResponse($headerData),
                'merchant_body'   => $this->homeService->findManyArticles('merchant_content', $languageId),
            ]
        );
    }

    public function merchantDetails(IdRequest $request): JsonResponse
    {
        $languageId = app()->make('language_id');
        $merchantId = $request->id;

        return $this->sendJsonResponse(
            'merchant_data',
            StatusEnum::SUCCESS->value,
            Response::HTTP_OK,
            '',
            $this->homeService->findManyArticlesDetails($merchantId, $languageId)
        );
    }

    /**
     * Fetch merchant data by language
     * @return \Illuminate\Http\JsonResponse
     */
    public function homeWhyChoose(): JsonResponse
    {
        $languageId = app()->make('language_id');
        $headerData = $this->homeService->findLangArticle('why_choose_header', $languageId);

        return $this->sendJsonResponse(
            'why_choose',
            StatusEnum::SUCCESS->value,
            Response::HTTP_OK,
            '',
            (object) [
                'why_choose_header' => $this->formateResponse($headerData),
                'why_choose_body'   => $this->homeService->findManyArticles('why_choose_content', $languageId),
            ]
        );
    }

    /**
     * Fetch satisfy customer data by language
     * @return \Illuminate\Http\JsonResponse
     */
    public function satisfyCustomer(): JsonResponse
    {
        $languageId = app()->make('language_id');
        $headerData = $this->homeService->findLangArticle('satisfied_customer_header', $languageId);
        return $this->sendJsonResponse(
            'satisfy_content',
            StatusEnum::SUCCESS->value,
            Response::HTTP_OK,
            '',
            (object) [
                'satisfied_customer_header' => $this->formateResponse($headerData),
                'customer_satisfy_body'     => $this->homeService->findManyArticles('customer_satisfy_content', $languageId),
            ]
        );
    }

    /**
     * Fetch faq customer data by language
     * @return \Illuminate\Http\JsonResponse
     */
    public function faq(): JsonResponse
    {
        $languageId = app()->make('language_id');
        $headerData = $this->homeService->findLangArticle('faq_header', $languageId);
        return $this->sendJsonResponse(
            'faq_content',
            StatusEnum::SUCCESS->value,
            Response::HTTP_OK,
            '',
            (object) [
                'faq_header' => $this->formateResponse($headerData),
                'faq_body'   => $this->homeService->findFaqArticles('faq_content', $languageId),
            ]
        );
    }

    /**
     * Fetch all supported payment gateway list
     * @return \Illuminate\Http\JsonResponse
     */
    public function gatewayList(): JsonResponse
    {
        $languageId = app()->make('language_id');
        $headerData = $this->homeService->findLangArticle('payment_we_accept_header', $languageId);

        return $this->sendJsonResponse(
            'gateways',
            StatusEnum::SUCCESS->value,
            Response::HTTP_OK,
            '',
            (object) [
                'header' => $this->formateResponse($headerData),
                'list'   => $this->homeService->gatewayList(),
            ],
        );
    }

    /**
     * Fetch Social Icon
     * @return \Illuminate\Http\JsonResponse
     */
    public function socialIcon(): JsonResponse
    {
        return $this->sendJsonResponse(
            'social_icon',
            StatusEnum::SUCCESS->value,
            Response::HTTP_OK,
            '',
            $this->homeService->findArticleData('social_icon')
        );
    }

    /**
     * Post Customer Register Info
     * @return \Illuminate\Http\JsonResponse
     */
    public function registration(CustomerRequest $request): JsonResponse
    {
        $data     = $request->all();
        $response = $this->customerService->create($data);

        if ($response) {
            return $this->sendJsonResponse(
                'registration',
                StatusEnum::SUCCESS->value,
                Response::HTTP_OK,
                localize('Your account has been successfully created. An activation link has been sent to your email. Please click this link to activate your account.'),
                (object) [],
            );
        } else {
            return $this->sendJsonResponse(
                'registration',
                StatusEnum::SUCCESS->value,
                Response::HTTP_INTERNAL_SERVER_ERROR,
                localize('Something went wrong!'),
                (object) [],
            );
        }

    }

    /**
     * Summary of bgImage
     * @return \Illuminate\Http\JsonResponse
     */
    public function bgImage(): JsonResponse
    {
        $bgImageData = $this->homeService->findArticleData('bg_effect_img');

        return $this->sendJsonResponse(
            'background_image',
            StatusEnum::SUCCESS->value,
            Response::HTTP_OK,
            '',
            $bgImageData[0]
        );
    }

}
