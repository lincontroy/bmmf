<?php

namespace App\Services;

use App\Models\SetupCommission;
use App\Repositories\Eloquent\CommissionSetupRepository;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;

class CommissionSetupService
{
    /**
     * CommissionSetupService constructor.
     *
     * @param CommissionSetupRepository $commissionSetupRepository
     */
    public function __construct(
        protected CommissionSetupRepository $commissionSetupRepository,
    ) {
    }

    public function all(): ?object
    {
        return $this->commissionSetupRepository->all();
    }

    /**
     * Create commission
     *
     * @param array $attributes
     * @return array
     * @throws Exception
     */
    public function create(array $attributes): object
    {
        $this->commissionSetupRepository->tableEmpty();
        try {
            DB::beginTransaction();
            $commission = [];
            foreach ($attributes['level'] as $key => $value) {
                $commission = $this->commissionSetupRepository->create([
                    'level_name'      => $value,
                    'personal_invest' => $attributes['personal_invest'][$key],
                    'total_invest'    => $attributes['total_invest'][$key],
                    'team_bonus'      => $attributes['team_bonus'][$key],
                    'referral_bonus'  => $attributes['referral_bonus'][$key],
                ]);
            }

            DB::commit();

            return $commission;
        } catch (Exception $exception) {
            DB::rollBack();

            throw $exception;
        }
    }

    /**
     * Update Customer
     *
     * @param array $attributes
     * @return bool
     * @throws Exception
     */
    public function update(array $attributes): bool
    {
        $customerID = $attributes['customer_id'];

        try {
            DB::beginTransaction();

            $this->customerRepository->updateById($customerID, $attributes);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(
                response()->json([
                    'success' => false,
                    'message' => localize("Customer update error"),
                    'title'   => localize('Customer'),
                    'errors'  => $exception,
                ], 422)
            );
        }
    }

}
