<?php

namespace App\Repositories\Eloquent;

use App\Models\MessengerUser;
use App\Repositories\Interfaces\MessengerRepositoryInterface;
use Carbon\Carbon;

class MessengerRepository extends BaseRepository implements MessengerRepositoryInterface
{
    public function __construct(MessengerUser $model)
    {
        parent::__construct($model);
    }

    public function customerInfo($id): object
    {
        return $this->model->newQuery()->where('id', $id)->with(['customerInfo'])->find($id);
    }

    /**
     * @inheritDoc
     */
    public function create(array $attributes): object
    {
        $data['user_name']      = $attributes['full_name'];
        $data['user_email']     = $attributes['email'];
        $data['message_status'] = '1';
        $data['msg_time']       = Carbon::now();
        $data['updated_at']     = Carbon::now();

        return $this->model->create($data);
    }

    public function searchMessengerUsers($attributes)
    {
        return $this->model->where('user_id', 'like', '%' . $attributes['user_id'] . '%')
                            ->orWhere('user_name', 'like', '%' . $attributes['user_id'] . '%')
                           ->get();
    }

    public function changeUserStatus($id): bool
    {
        return $this->model->where('id', $id)
                           ->where('message_status', '0')
                           ->update(['message_status' => '1']);
    }
}
