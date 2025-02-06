<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface MessageRepositoryInterface extends BaseRepositoryInterface
{
    public function findUserMessage(string $searchColumn, string $columnValue, int $limit): ?object;
    public function createNewMessage(array $data): object;
    public function customerMessages(array $data): object;
    public function setMsgRead(): bool;
    public function changeStatus($id): bool;
    public function countUnreadMessages($userId): int;
}
