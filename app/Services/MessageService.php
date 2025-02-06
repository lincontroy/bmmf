<?php

namespace App\Services;

use App\Repositories\Interfaces\MessageRepositoryInterface;

class MessageService
{
    /**
     * MessengerService constructor.
     *
     */
    public function __construct(
        protected MessageRepositoryInterface $messageRepository,
    ) {
    }

    public function countUnreadMessage(string $userId = null): int
    {
        return $this->messageRepository->countUnreadMessages($userId);
    }

}
