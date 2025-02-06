<?php

namespace App\Services;

use App\Repositories\Interfaces\MessageRepositoryInterface;
use App\Repositories\Interfaces\MessengerRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Exception;

class MessengerService
{
    /**
     * MessengerService constructor.
     *
     * @param MessengerRepositoryInterface $messengerRepository
     */
    public function __construct(
        protected MessengerRepositoryInterface $messengerRepository,
        protected MessageRepositoryInterface $messageRepository,
    
    ) {
    }

     /**
     * Create Contact Us Message
     *
     * @param array $attributes
     * @return array
     * @throws Exception
     */
    public function create(array $attributes): object
    {
        $email = $attributes['email'];
        $checkExitEmail = $this->messengerRepository->firstWhere('user_email', $email);

        try {
            DB::beginTransaction();
            if ($checkExitEmail) {
                $attributes['msg_log_id'] = $checkExitEmail->id;
                $uData['message_status'] = '1';
                $uData['msg_time'] = Carbon::now();
                $this->messengerRepository->updateById($checkExitEmail->id, $uData);
            } else {
                $res = $this->messengerRepository->create($attributes);
                $attributes['msg_log_id'] = $res->id;
            }
            
            $message = $this->messageRepository->createNewMessage($attributes);
            DB::commit();

            return $message;
        } catch (Exception $exception) {
            DB::rollBack();

            throw $exception;
        }
    }


}