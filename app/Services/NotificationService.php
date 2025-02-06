<?php

namespace App\Services;

use App\Repositories\Interfaces\NotificationRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class NotificationService
{
    public function __construct(
        private NotificationRepositoryInterface $notificationRepository
    ) {

    }

    /**
     * Create Notification
     * @param array $attributes
     * @return object
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function create(array $attributes): ?object
    {
        try {
            DB::beginTransaction();
            $notification = $this->notificationRepository->create($attributes);
            DB::commit();
            return $notification;
        } catch (Exception $exception) {
            DB::rollBack();
            handleException($exception, localize("Notification Create error"), localize('Notification Create'));
        }
    }

    /**
     * All Notification
     * @param array $attributes
     * @return object
     */
    public function all(array $attributes): ?object
    {
        return $this->notificationRepository->all($attributes);
    }

    /**
     * Count Notification
     * @param array $attributes
     * @return integer
     */
    public function countByAttributes(array $attributes): int
    {
        return $this->notificationRepository->countByAttributes($attributes);
    }

    /**
     * Paginate Notification
     * @param array $attributes
     * @return object
     */
    public function notificationPaginate(array $attributes): ?object
    {
        return $this->notificationRepository->notificationPaginate($attributes);
    }

    /**
     * Update Read Notification
     * @param array $attributes
     * @return bool
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function readNotification(array $attributes): bool
    {
        try {
            DB::beginTransaction();
            $this->notificationRepository->readNotification($attributes);
            DB::commit();
            return true;
        } catch (Exception $exception) {
            DB::rollBack();
            handleException($exception, localize("Notification Read error"), localize('Notification Read'));
            return false;
        }
    }
}
