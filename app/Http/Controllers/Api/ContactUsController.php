<?php

namespace App\Http\Controllers\Api;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactUsRequest;
use App\Services\HomeService;
use App\Services\MessengerService;
use App\Services\WebsiteService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContactUsController extends Controller
{
    use ResponseTrait;

    /**
     * WebsiteController constructor
     *
     */
    public function __construct(
        private WebsiteService $websiteService,
        private HomeService $homeService,
        private MessengerService $messengerService,
    ) {

    }

    /**
     * Post Contact Us Info
     * @return \Illuminate\Http\JsonResponse
     */
    public function contactUs(ContactUsRequest $request): JsonResponse
    {
        $data = $request->all();

        $data['replay_status'] = "0";
        $data['msg_status']    = "1";
        $response              = $this->messengerService->create($data);

        if ($response) {
            return $this->sendJsonResponse(
                'contact_us',
                StatusEnum::SUCCESS->value,
                Response::HTTP_OK,
                localize('Message send successfully!'),
                (object) [],
            );
        } else {
            return $this->sendJsonResponse(
                'contact_us',
                StatusEnum::SUCCESS->value,
                Response::HTTP_INTERNAL_SERVER_ERROR,
                localize('Something went wrong!'),
                (object) [],
            );
        }

    }

    /**
     * Post Contact Us Info
     * @return \Illuminate\Http\JsonResponse
     */
    public function contactUsBanner(Request $request): JsonResponse
    {
        return $this->sendJsonResponse(
            'contact_us',
            StatusEnum::SUCCESS->value,
            Response::HTTP_OK,
            '',
            (object) [
                'contact_us_banner' => $this->websiteService->findLangManyArticles('contact_us_top_banner', app()->make('language_id')),
                'contact_address'   => $this->websiteService->findLangManyArticles('contact_address', app()->make('language_id')),
            ],
        );
    }

}