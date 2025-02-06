<?php

namespace App\Repositories\Eloquent;

use App\Models\Message;
use App\Repositories\Interfaces\MessageRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class MessageRepository extends BaseRepository implements MessageRepositoryInterface
{
    public function __construct(Message $model)
    {
        parent::__construct($model);
    }

    /**
     * Find user recent message get by ordering asc
     * @param string $searchColumn
     * @param string $columnValue
     * @param int $limit
     * @return mixed
     */
    public function findUserMessage(string $searchColumn, string $columnValue, int $limit): ?object
    {
        return $this->model->where($searchColumn, $columnValue)->latest()->take($limit)
                           ->get()->sortBy('id');
    }

    public function customerMessages(array $data = []): object
    {
        return $this->model->newQuery()
                           ->where('messenger_user_id', $data['id'])
                           ->latest()
                           ->with(['customerInfo'])
                           ->get()
                           ->sortBy('id');
    }

    /**
     * Create new message
     * @param array $data
     * @return bool
     */
    public function createNewMessage(array $data): object
    {
        $attributes = [];
        $attributes['messenger_user_id'] = $data['msg_log_id'];
        $attributes['user_id'] = $data['user_id'] ?? null;
        $attributes['msg_subject'] = $data['subject'] ?? null;
        $attributes['msg_body'] = $data['message'];
        $attributes['msg_time'] = Carbon::now();
        if (isset($data['replay_status'])) {
            $attributes['replay_status'] = $data['replay_status'];
        }
        if (isset($data['msg_status'])) {
            $attributes['msg_status'] = $data['msg_status'];
        }
        
        return $this->model->create($attributes);
    }

    /**
     * Set message read from customer
     * @return bool
     */
    public function setMsgRead(): bool
    {
        $readStatusResult = $this->model->where('user_id', Auth::user()->user_id)->where('msg_status', 1)
                                        ->where('replay_status', 1)->update(['msg_status' => 0]);

        return $readStatusResult;
    }

    public function changeStatus($id): bool
    {
        return $this->model->where('messenger_user_id', $id)
                           ->where('replay_status', '0')
                           ->update(['msg_status' => '0']);
    }

    public function updateAll($userId): bool
    {
        return $this->model->where('user_id', $userId)
                           ->where('replay_status', "1")
                           ->where('msg_status', "1")
                           ->update(['msg_status' => "0"]);
    }

    public function countUnreadMessages($userId): int
    {
        if ($userId) {
            $result = $this->model->where('msg_status', '1')->where('replay_status', '1')->where(
                'user_id',
                $userId
            )->count();
        } else {
            $result = $this->model->where('msg_status', '1')->where('replay_status', '0')->distinct('user_id')->groupBy('user_id')->count();
        }

        return $result;
    }

}
