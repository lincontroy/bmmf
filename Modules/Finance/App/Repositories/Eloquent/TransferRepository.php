<?php

namespace Modules\Finance\App\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepository;
use Modules\Finance\App\Models\Transfer;
use Modules\Finance\App\Repositories\Interfaces\TransferRepositoryInterface;

class TransferRepository extends BaseRepository implements TransferRepositoryInterface
{
    public function __construct(Transfer $model)
    {
        parent::__construct($model);
    }

    /**
     * get credit details by deposit id
     *
     * @param array $attributes
     * @return void
     */
    public function getAllReceived(array $attributes): ?object
    {
        return $this->model->newQuery()->where('receiver_user_id', $attributes['user_id'])->with('senderInformation')->orderBy('id', 'desc')->get();
    }

    /**
     * get credit details by deposit id
     *
     * @param array $attributes
     * @return void
     */
    public function getAllTransfer(array $attributes): ?object
    {
        return $this->model->newQuery()->where('sender_user_id', $attributes['user_id'])->with('receiverInformation')->orderBy('id', 'desc')->get();
    }

    /**
     * @inheritDoc
     */
    public function updateById(int $id, array $attributes): bool
    {
        return parent::updateById(
            $id,
            $attributes
        );
    }

    /**
     * get credit details by deposit id
     *
     * @param int $id
     * @return void
     */
    public function transferDetails($id): ?object
    {

        return $this->model->newQuery()->where('id', $id)->with(['senderInformation', 'receiverInformation'])->first();

    }

}
