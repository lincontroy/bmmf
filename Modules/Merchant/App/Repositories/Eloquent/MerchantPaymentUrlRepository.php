<?php

namespace Modules\Merchant\App\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Modules\Merchant\App\Models\MerchantPaymentUrl;
use Modules\Merchant\App\Repositories\Interfaces\MerchantPaymentUrlRepositoryInterface;

class MerchantPaymentUrlRepository extends BaseRepository implements MerchantPaymentUrlRepositoryInterface
{
    /**
     * MerchantPaymentUrlRepository constructor
     *
     * @param MerchantPaymentUrl $model
     */
    public function __construct(MerchantPaymentUrl $model)
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

        if (isset($attributes['uu_id'])) {
            $query = $query->where('uu_id', $attributes['uu_id']);
        }

        if (isset($attributes['merchant_account_id'])) {
            $query = $query->where('merchant_account_id', $attributes['merchant_account_id']);
        }

        if (isset($attributes['title'])) {
            $query = $query->where('title', $attributes['title']);
        }

        if (isset($attributes['fiat_currency_id'])) {
            $query = $query->where('fiat_currency_id', $attributes['fiat_currency_id']);
        }

        if (isset($attributes['customer_id'])) {
            $query = $query->whereHas('merchantAccount', function ($qry) use ($attributes) {
                $qry->whereHas('customerInfo', function ($q) use ($attributes) {
                    $q->where('id', $attributes['customer_id']);
                });
            });
        }

        if (isset($attributes['user_id'])) {
            $query = $query->whereHas('merchantAccount', function ($qry) use ($attributes) {
                $qry->where('user_id', $attributes['user_id']);
            });
        }

        if (isset($attributes['status'])) {
            $query = $query->where('status', $attributes['status']);
        }

        return $query;
    }

    /**
     * Fillable data
     *
     * @param  array  $attributes
     * @return array
     */
    private function fillable(array $attributes): array
    {
        $data = [
            'merchant_account_id' => $attributes['merchant_account_id'],
            'title'               => $attributes['title'],
            'description'         => $attributes['description'],
            'amount'              => $attributes['amount'],
            'fiat_currency_id'    => $attributes['fiat_currency_id'],
            'status'              => $attributes['status'],
        ];

        if (isset($attributes['duration'])) {
            $data['duration'] = Carbon::parse($attributes['duration'])->format('Y-m-d H:i:s');
        } else {
            $data['duration'] = Carbon::now()->format('Y-m-d H:i:s');
        }

        return $data;

    }

    /**
     * @inheritDoc
     */
    public function all(array $attributes = []): ?object
    {
        return $this->baseQuery($attributes)->get();
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
    public function updateById(int $id, array $attributes): bool
    {
        $data = $this->fillable($attributes);
        return parent::updateById($id, $data);
    }

    /**
     * @inheritDoc
     */
    public function updateByCurrentTime(): bool
    {
        return $this->model->where('duration', '<', Carbon::now()->format('Y-m-d H:i:s'))->update(['status' => '0']);
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
    public function merchantPaymentUrlTable(array $attributes = []): Builder
    {
        return $this->baseQuery($attributes)->with(['fiatCurrency', 'merchantAcceptedCoins']);
    }

    /**
     * @inheritDoc
     */
    public function findWithCurrency(int $id): object
    {
        return $this->model->with(['fiatCurrency', 'merchantAcceptedCoins'])->find($id);
    }

    /**
     * @inheritDoc
     */
    public function findByUuidWithCurrency(string $uu_id): ?object
    {
        return $this->baseQuery(['uu_id' => $uu_id])->with(['fiatCurrency', 'merchantAcceptedCoins.acceptCurrency', 'merchantAccount'])->first();
    }

    /**
     * @inheritDoc
     */
    public function findByUuidWithMerchantAcceptCoin(string $uu_id, ?int $accept_currency_id): ?object
    {
        return $this->baseQuery(['uu_id' => $uu_id])->with([
            'merchantAcceptedCoin' => function ($query) use ($accept_currency_id) {

                if ($accept_currency_id) {
                    $query->where('accept_currency_id', $accept_currency_id);
                }

            },

        ])->first();
    }

}
