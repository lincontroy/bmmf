<?php

namespace App\Repositories\Eloquent;

use App\Enums\NotificationEnum;
use App\Models\Notification;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Interfaces\NotificationRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class NotificationRepository extends BaseRepository implements NotificationRepositoryInterface
{
    /**
     * MerchantPaymentTransactionRepository constructor
     *
     * @param MerchantPaymentTransaction $model
     */
    public function __construct(Notification $model)
    {
        parent::__construct($model);
    }

    /**
     * Base query
     *
     * @param  array  $attributes
     * @return Builder
     */
    private function baseQuery(array $attributes = []): Builder
    {

        $query = $this->model->newQuery();

        if (isset($attributes['id'])) {
            $query = $query->where('id', $attributes['id']);
        }

        if (isset($attributes['customer_id'])) {
            $query = $query->where('customer_id', $attributes['customer_id']);
        }

        if (isset($attributes['notification_type'])) {
            $query = $query->where('notification_type', $attributes['notification_type']);
        }

        if (isset($attributes['status'])) {
            $query = $query->where('status', $attributes['status']);
        }

        return $query;
    }

    /**
     * @inheritDoc
     */
    public function all(array $attributes = []): ?object
    {
        return $this->baseQuery($attributes)->orderBy('id', 'desc')->get();
    }

    /**
     * @inheritDoc
     */
    public function findByAttributes(array $attributes = [], array $relations = []): ?object
    {
        return $this->baseQuery($attributes)->with($relations)->first();
    }

    /**
     * @inheritDoc
     */
    public function getByAttributes(array $attributes = [], array $relations = []): ?object
    {
        return $this->baseQuery($attributes)->with($relations)->get();
    }

    /**
     * @inheritDoc
     */
    public function countByAttributes(array $attributes = []): int
    {
        return $this->baseQuery($attributes)->count();
    }

    /**
     * @inheritDoc
     */
    public function notificationPaginate(array $attributes = [], array $relations = [], int $perPage = 10): ?object
    {
        return $this->baseQuery($attributes)->orderBy('id', 'desc')->with($relations)->paginate($perPage);
    }

    /**
     * @inheritDoc
     */
    public function readNotification(array $attributes): bool
    {
        $data = [
            'status' => NotificationEnum::READ,
        ];
        return $this->baseQuery($attributes)->update($data);
    }

}
