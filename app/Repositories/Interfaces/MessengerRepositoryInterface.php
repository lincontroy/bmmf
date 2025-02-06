<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface MessengerRepositoryInterface extends BaseRepositoryInterface
{
    public function create(array $attributes): object;
    public function customerInfo($id): object;
    public function changeUserStatus($id): bool;
}
