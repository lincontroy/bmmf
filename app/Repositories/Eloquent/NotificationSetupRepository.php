<?php

namespace App\Repositories\Eloquent;

use App\Models\NotificationSetup;
use App\Repositories\Interfaces\NotificationSetupRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class NotificationSetupRepository extends BaseRepository implements NotificationSetupRepositoryInterface
{
    public function __construct(NotificationSetup $model)
    {
        parent::__construct($model);
    }

    /**
     * Fillable data for user
     *
     * @param  array  $attributes
     * @return array
     */
    private function fillable(array $attributes): array
    {
        $data = [];

        if (isset($attributes['group'])) {
            $data['group'] = $attributes['group'];
        }

        if (isset($attributes['name'])) {
            $data['name'] = $attributes['name'];
        }

        if (isset($attributes['status'])) {
            $data['status'] = $attributes['status'];
        }

        return $data;
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

        if (!empty($attributes['group'])) {
            $query = $query->where('group', $attributes['group']);
        }

        if (!empty($attributes['name'])) {
            $query = $query->where('name', $attributes['name']);
        }

        if (!empty($attributes['status'])) {
            $query = $query->where('status', $attributes['status']);
        }

        return $query;
    }

    /**
     * @inheritDoc
     */
    public function getGroupWiseNotifications(string $groupName): object
    {
        $query = $this->baseQuery(['group' => $groupName])->get();

        return $query;
    }

    /**
     * @inheritDoc
     */
    public function updateByGroup($group, array $attributes): bool
    {
        $data = $this->fillable($attributes);
        return $this->model->where('group', $group)->update($data);
    }

    /**
     * @inheritDoc
     */
    public function updateByGroupAndId($group, int $notificationSetupId, array $attributes): bool
    {
        $data = $this->fillable($attributes);
        return $this->model->where('group', $group)->where('id', $notificationSetupId)->update($data);
    }

}
