<?php

namespace Modules\Support\App\Services;

use App\Mail\UserReplayEmail;
use App\Repositories\Eloquent\MessageRepository;
use App\Repositories\Interfaces\MessengerRepositoryInterface;
use Illuminate\Support\Facades\Mail;

class SupportService
{
    /**
     * SupportService constructor.
     *
     */
    public function __construct(
        private MessageRepository $messageRepository,
        private MessengerRepositoryInterface $messengerRepository,
    ) {
    }

    /**
     * get all active customers
     *
     * @param int $pageNo
     * @return object|null
     */
    public function allMessengerUsers(array $attributes = []): ?object
    {
        $pageNo = $attributes['page_no'];

        return $this->messengerRepository->orderPaginate(
            [
                "orderByColumn"     => "msg_time",
                "order"             => "asc",
                "perPage"           => 10,
                "page"              => $pageNo,
            ],
            ['customerInfo'],
        );
    }

    /**
     * Count unread messages
     *
     * @param int $pageNo
     * @return object|null
     */
    public function countUnreadMessages(): int
    {
        return $this->messageRepository->countUnreadMessages();
    }

    /**
     * get all active customers
     *
     * @param int $pageNo
     * @return object|null
     */
    public function searchMessengerUsers(array $attributes = []): ?object
    {
        return $this->messengerRepository->searchMessengerUsers($attributes);
    }

    /**
     * get all unread message
     *
     * @param int $pageNo
     * @return object|null
     */
    public function inboxMessage(array $attributes = []): ?object
    {
        return $this->messageRepository->inboxMessage();
    }

    /**
     * get all message
     *
     * @param $id
     * @return object|null
     */
    public function customerMessages($id): ?object
    {
        $attributes['id'] = $id;

        return $this->messageRepository->customerMessages($attributes);
    }

    public function customerInfo(int $id): ?object
    {
        return $this->messengerRepository->customerInfo($id);
    }

    public function changeStatus(int $id): bool
    {
        return $this->messageRepository->changeStatus($id);
    }
    public function changeUserStatus(int $id): bool
    {
        return $this->messengerRepository->changeUserStatus($id);
    }

    public function checkUserExist(int $userId): object
    {
        return $this->messengerRepository->firstWhere('id', $userId);
    }

    public function sentMessage(array $data): object
    {
        return $this->messageRepository->createNewMessage($data);
    }

    public function sentMessageMail(array $attributes = [])
    {
        $email = $attributes['to'];
        Mail::to($email)->send(new UserReplayEmail($attributes));
    }

}