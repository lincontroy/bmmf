<?php

namespace App\Repositories\Eloquent;

use App\Models\MessageUserModel;
use App\Models\MessengerUser;
use App\Repositories\Interfaces\MessageUserRepositoryInterface;

class MessageUserRepository extends BaseRepository implements MessageUserRepositoryInterface
{
    public function __construct(MessengerUser $model)
    {
        parent::__construct($model);
    }

    /**
     * Create messenger user
     * @param array $data
     * @return int
     */
    public function createUser(array $data)
    {
        $msgUser['user_id']        = $data["user_id"];
        $msgUser['user_name']      = $data["userName"];
        $msgUser['user_email']     = $data["userEmail"];
        $msgUser['message_status'] = '0';
        $msgUser['msg_time']       = $data['nowTime'];
        $res = $this->model->create($msgUser);

        return $res->id;
    }

    /**
     * Make user unread for admin
     * @return bool
     */
    public function setStatus(int $messengerId): bool
    {
        $data = [
            'message_status' => '0',
            'msg_time'       => date('Y-m-d H:i:s'),
        ];

        return parent::updateById($messengerId, $data);
    }
}
