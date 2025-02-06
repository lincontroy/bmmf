<?php

namespace App\Repositories\Eloquent;

use App\Enums\StatusEnum;
use App\Models\WalletManage;
use App\Models\WalletTransactionLog;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Interfaces\WalletManageRepositoryInterface;
use App\Repositories\Interfaces\WalletTransactionLogRepositoryInterface;

class WalletTransactionLogRepository extends BaseRepository implements WalletTransactionLogRepositoryInterface
{
    public function __construct(WalletTransactionLog $walletTransactionLog)
    {
        parent::__construct($walletTransactionLog);
    }

    /**
     * @inheritDoc
     */
    public function create(array $attributes): object
    {
        return parent::create($attributes);
    }

    public function userTransactionLogs(array $attributes):  ?object
    {
        $userId = $attributes['user_id'];

        return $this->model->where('user_id', $userId)->orderBy('id','desc')->with(['currency'])->paginate(10);
    }

}
