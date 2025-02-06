<?php

namespace Modules\Support\App\Http\Controllers;

use App\Enums\PermissionActionEnum;
use App\Enums\PermissionMenuEnum;
use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Services\SettingService;
use App\Traits\ChecksPermissionTrait;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Support\App\Services\SupportService;
use Symfony\Component\HttpFoundation\Response;

class SupportController extends Controller
{
    use ResponseTrait;
    use ChecksPermissionTrait;

    public $mapActionPermission;

    /**
     * SupportController constructor
     *
     */
    public function __construct(
        private SupportService $supportService,
        private SettingService $settingService,
    ) {
        $this->mapActionPermission = [
            'index'   => PermissionMenuEnum::SUPPORT->value . '.' . PermissionActionEnum::READ->value,
            'create'  => PermissionMenuEnum::SUPPORT->value . '.' . PermissionActionEnum::READ->value,
            'store'   => PermissionMenuEnum::SUPPORT->value . '.' . PermissionActionEnum::READ->value,
            'show'    => PermissionMenuEnum::SUPPORT->value . '.' . PermissionActionEnum::READ->value,
            'search'  => PermissionMenuEnum::SUPPORT->value . '.' . PermissionActionEnum::READ->value,
            'onLoad'  => PermissionMenuEnum::SUPPORT->value . '.' . PermissionActionEnum::READ->value,
            'edit'    => PermissionMenuEnum::SUPPORT->value . '.' . PermissionActionEnum::READ->value,
            'update'  => PermissionMenuEnum::SUPPORT->value . '.' . PermissionActionEnum::READ->value,
            'destroy' => PermissionMenuEnum::SUPPORT->value . '.' . PermissionActionEnum::READ->value,
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $attributes['page_no'] = $request->input('page_no', 1);

        $customers = $this->supportService->allMessengerUsers($attributes);

        return view('support::index', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $userId    = $request['userid'];
        $checkUser = $this->supportService->checkUserExist($userId);

        if (!$checkUser) {
            return $this->sendJsonResponse(
                'user-not-found',
                StatusEnum::SUCCESS->value,
                Response::HTTP_OK,
                localize('User not found!'),
                (object) []
            );
            exit();
        }

        $data['user_id']       = $checkUser->user_id;
        $data['msg_log_id']    = $checkUser->id;
        $data['message']       = $request['message'];
        $data['msg_time']      = Carbon::now();
        $data['replay_status'] = '1';
        $data['msg_status']    = '1';

        if ($checkUser->user_id) {
            $res = $this->supportService->sentMessage($data);

            return $this->sendJsonResponse(
                'send-message',
                StatusEnum::SUCCESS->value,
                Response::HTTP_OK,
                localize('Message Send Successfully!'),
                $res,
            );
        } else {
            $email      = $checkUser->user_email;
            $appSetting = $this->settingService->findById();

            $res = $this->supportService->sentMessage($data);

            if ($res) {
                $emailData = [
                    'title'   => $appSetting->title,
                    'subject' => $appSetting->title . ' SUPPORT',
                    'to'      => $email,
                    'message' => $request['message'],
                ];

                $this->supportService->sentMessageMail($emailData);
            }

            return $this->sendJsonResponse(
                'send-message',
                StatusEnum::SUCCESS->value,
                Response::HTTP_OK,
                localize('Message Send Successfully!'),
                $res,
            );
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('support::create');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function show(int $id): view
    {
        $customer         = $this->supportService->customerInfo($id);
        $customerMessages = $this->supportService->customerMessages($id);

        $this->supportService->changeStatus($id);
        $this->supportService->changeUserStatus($id);

        return view('support::show', compact('customer', 'customerMessages'));
    }

    /**
     * Show the specified resource.
     * @param string $userId
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function search(Request $request): view
    {
        $attributes['user_id'] = $request['userid'];

        $customers = $this->supportService->searchMessengerUsers($attributes);

        return view('support::search_users', compact('customers'));
    }

    /**
     * Show the specified resource.
     * @param string $userId
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function onLoad(Request $request): view
    {
        $attributes['page_no'] = $request->input('pageNo');

        $customers = $this->supportService->allMessengerUsers($attributes);

        return view('support::onload_users', compact('customers'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('support::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

}
