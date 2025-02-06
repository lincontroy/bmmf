<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\MessageRepositoryInterface;
use App\Repositories\Interfaces\MessageUserRepositoryInterface;
use App\Services\CustomerService;
use App\Services\SettingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class HelplineController extends Controller
{
    private $user_id;
    private $message;
    private $messageUser;
    private $settings;

    public function __construct(
        MessageRepositoryInterface $message,
        MessageUserRepositoryInterface $messageUser,
        protected SettingService $settingService,
        protected CustomerService $customerService,
    ) {
        $this->message     = $message;
        $this->messageUser = $messageUser;
    }

    /**
     * Helpline page
     * @return View
     */
    public function add(): View
    {
        cs_set('theme', [
            'title'       => localize('Support'),
            'description' => localize('Support'),
        ]);

        $customerId       = Auth::id();
        $this->user_id    = Auth::user()->user_id;
        $data['chatList'] = $this->message->findUserMessage('user_id', Auth::user()->user_id, 100);
        $data['settings'] = $this->settingService->findById();
        $data['user']     = $this->customerService->findOrFail($customerId);
        $unreadMessage    = $this->message->countUnreadMessages($this->user_id);
        if($unreadMessage > 0){
            $this->message->updateAll($this->user_id);
        }

        return view("helpline.add", $data);
    }

    /**
     * Send user message
     * @param Request $request
     * @return JsonResponse
     */
    public function send(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            "message" => "required|string|max:500",
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'msg' => $validator->messages()->first('message')]);
        }
        $validated     = $validator->validate();
        $userId = Auth::user()->user_id;
        $nowTime       = date('Y-m-d H:i:s');
        $messengerUser = $this->messageUser->firstWhere('user_id', $userId);
        try {
            DB::beginTransaction();
            if ($messengerUser) {
                $messengerId = $messengerUser->id;
                $this->messageUser->setStatus($messengerId);
            } else {
                $msgUserData = [
                    'user_id'   => $userId,
                    'userName'  => Auth::user()->first_name . ' ' . Auth::user()->last_name,
                    'userEmail' => Auth::user()->email,
                    'nowTime'   => $nowTime,
                ];

                $messengerId = $this->messageUser->createUser($msgUserData);

            }
            $messageData = [
                'msg_log_id'    => $messengerUser->id ?? $messengerId,
                'user_id'       => $userId,
                'subject'       => "",
                'message'       => $validated['message'],
                'replay_status' => "0",
                'msg_status'    => "1",
                'msg_time'      => $nowTime,
            ];

            $this->message->createNewMessage($messageData);

            DB::commit();

            return response()->json(['status' => 'success', 'data' => ['time' => $nowTime]]);
        } catch (Exception $ex) {
            DB::rollBack();

            return response()->json(['status' => 'error', 'msg' => $ex->getMessage()]);
        }
    }
}
