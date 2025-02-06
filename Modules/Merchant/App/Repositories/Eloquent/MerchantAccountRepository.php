<?php

namespace Modules\Merchant\App\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Modules\Merchant\App\Models\MerchantAccount;
use Modules\Merchant\App\Repositories\Interfaces\MerchantAccountRepositoryInterface;

class MerchantAccountRepository extends BaseRepository implements MerchantAccountRepositoryInterface
{
    public function __construct(MerchantAccount $model)
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

        if (isset($attributes['user_id'])) {
            $query = $query->where('user_id', $attributes['user_id']);
        }

        return $query;
    }

    /**
     * Prepare data for deposit
     *
     * @param array $attributes
     * @return array
     */
    private function fillable(array $attributes): array
    {
        return [
            'user_id'     => $attributes['user_id'],
            'store_name'  => $attributes['store_name'],
            'email'       => $attributes['email'],
            'about'       => $attributes['about'] ?? null,
            'phone'       => $attributes['phone'] ?? null,
            'website_url' => $attributes['website_url'] ?? null,
            'logo'        => $attributes['logo'] ?? null,
            'status'      => $attributes['status'] ?? '2',
        ];
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
     * @inheritDoc
     */
    public function create(array $attributes): object
    {
        $data = $this->fillable($attributes);

        return parent::create($data);
    }

    /**
     * @inheritDoc
     */
    public function queryByAttributes(array $attributes):Builder
    {
        return $this->baseQuery($attributes);
    }


    /**
     * @inheritDoc
     */
    public function findByIdWithCustomer(int $id): ?object
    {
        return $this->model->with('customerInfo')->find($id);
    }

}
