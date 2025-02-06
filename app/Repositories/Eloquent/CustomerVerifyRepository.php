<?php

namespace App\Repositories\Eloquent;

use App\Enums\StatusEnum;
use App\Models\CustomerVerifyDoc;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Interfaces\CustomerVerifyRepositoryInterface;
use Modules\Package\App\Enums\CapitalBackEnum;

class CustomerVerifyRepository extends BaseRepository implements CustomerVerifyRepositoryInterface
{
    public function __construct(CustomerVerifyDoc $model)
    {
        parent::__construct($model);
    }

    /**
     * @inheritDoc
     */
    public function create(array $attributes): object
    {
        $data       = $this->fillable($attributes);
        $investType = $attributes['invest_type'];
        $returnType = $attributes['return_type'];

        if ($investType == '1') {
            $data['min_price'] = $attributes['min_price'];
            $data['max_price'] = $attributes['max_price'];
        } else {
            $data['min_price'] = $attributes['amount'];
        }

        if ($returnType == '2') {
            $data['repeat_time']  = $attributes['repeat_time'];
            $data['capital_back'] = CapitalBackEnum::YES->value;
        } else {
            $data['capital_back'] = CapitalBackEnum::NO->value;
        }

        $data['status'] = StatusEnum::ACTIVE->value;

        return parent::create($data);
    }

    /**
     * Prepare data for package
     *
     * @param array $attributes
     * @return array
     */
    private function fillable(array $attributes): array
    {
        return [
            'plan_time_id'  => $attributes['plan_time_id'],
            'name'          => $attributes['name'],
            'invest_type'   => $attributes['invest_type'],
            'interest_type' => $attributes['interest_type'],
            'interest'      => $attributes['interest'],
            'return_type'   => $attributes['return_type'],
        ];
    }

    /**
     * @inheritDoc
     */
    public function updateById(int $id, array $attributes): bool
    {
        $data = $this->fillable($attributes);

        $investType = $attributes['invest_type'];
        $returnType = $attributes['return_type'];

        if ($investType == '2') {
            $data['min_price'] = $attributes['amount'];
        } else {
            $data['min_price'] = $attributes['min_price'];
            $data['max_price'] = $attributes['max_price'];
        }

        if ($returnType == '2') {
            $data['repeat_time']  = $attributes['repeat_time'];
            $data['capital_back'] = $attributes['capital_back'];
        } else {
            $data['repeat_time']  = null;
            $data['capital_back'] = CapitalBackEnum::NO->value;
        }

        return parent::updateById(
            $id,
            $data
        );
    }

    /**
     * Prepare data for package
     *
     * @param array $attributes
     * @return array
     */
    private function fillableCustomerVerifyDoc(array $attributes): array
    {
        return [
            'customer_id'   => $attributes['customer_id'],
            'first_name'    => $attributes['first_name'],
            'last_name'     => $attributes['last_name'],
            'gender'        => $attributes['gender'],
            'country'       => $attributes['country'],
            'state'         => $attributes['state'] ?? null,
            'city'          => $attributes['city'],
            'document_type' => $attributes['document_type'],
            'id_number'     => $attributes['id_number'],
            'expire_date'   => $attributes['expire_date'],
            'document1'     => $attributes['document1'],
            'document2'     => $attributes['document2'],
            'document3'     => $attributes['document3'],
        ];
    }

    /**
     * @inheritDoc
     */
    public function createCustomerVerifyDoc(array $attributes): object
    {
        $data                = $this->fillableCustomerVerifyDoc($attributes);
        $data['verify_type'] = 1;

        return parent::create($data);
    }

}
