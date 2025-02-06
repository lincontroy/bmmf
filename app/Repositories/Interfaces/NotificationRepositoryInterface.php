<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface NotificationRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Count by Attributes
     *
     * @param array $attributes
     * @return integer
     */
    public function countByAttributes(array $attributes = []): int;

    /**
     * Notification Paginate
     *
     * @param array $attributes
     * @param array $relations
     * @param integer $perPage
     * @return object|null
     */
    public function notificationPaginate(array $attributes = [], array $relations = [], int $perPage = 10): ?object;

    /**
     * Read Notification
     *
     * @param array $attributes
     * @return boolean
     */
    public function readNotification(array $attributes): bool;
}
