<?php

namespace Modules\B2xloan\App\Services;

use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Modules\B2xloan\App\Repositories\Interfaces\B2xLoanRepositoryInterface;

class B2xLoanService
{
    /**
     * B2xLoanService constructor.
     *
     */
    public function __construct(
        private B2xLoanRepositoryInterface $b2xLoanRepository,
    ) {
    }

    /**
     * get data by id
     * @param mixed $id
     * @return object
     */
    public function findById($id): object
    {
        $package = $this->b2xLoanRepository->find($id);

        return $package;
    }

    public function pendingAndSuccessLoanAmount(int $customerId)
    {
        $attributes['customer_id'] = $customerId;

        return $this->b2xLoanRepository->pendingAndSuccessLoanAmount($attributes);
    }

    /**
     * Create loan
     *
     * @param array $attributes
     * @return array
     * @throws Exception
     */
    public function create(array $attributes): object
    {
        try {
            DB::beginTransaction();
            $loan = $this->b2xLoanRepository->create($attributes);
            DB::commit();

            return $loan;
        } catch (Exception $exception) {
            DB::rollBack();

            throw $exception;
        }
    }

    /**
     * Update loan status
     *
     * @param array $attributes
     * @return bool
     * @throws Exception
     */
    public function update(array $attributes): bool
    {
        $loanId               = $attributes['loan_id'];
        $status               = $attributes['set_status'];
        $data['status']       = $status;
        $data['checker_note'] = $attributes['checker_note'];

        try {
            DB::beginTransaction();

            $this->b2xLoanRepository->updateById($loanId, $data);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(
                response()->json([
                    'success' => false,
                    'message' => localize("Loan update error"),
                    'title'   => localize('B2xLoan'),
                    'errors'  => $exception,
                ], 422)
            );
        }
    }

    /**
     * Update loan installment
     *
     * @param array $attributes
     * @return bool
     * @throws Exception
     */
    public function repayLoanUpdate($loanId, array $attributes): bool
    {
        try {
            DB::beginTransaction();

            $this->b2xLoanRepository->updateById($loanId, $attributes);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(
                response()->json([
                    'success' => false,
                    'message' => localize("Loan update error"),
                    'title'   => localize('B2xLoan'),
                    'errors'  => $exception,
                ], 422)
            );
        }
    }

    /**
     * Update loan status
     *
     * @param array $attributes
     * @return bool
     * @throws Exception
     */
    public function withdrawUpdate(array $attributes): bool
    {
        $loanId                  = $attributes['loan_id'];
        $status                  = $attributes['set_status'];
        $data['withdraw_status'] = $status;
        $data['withdraw_note']   = $attributes['checker_note'];

        try {
            DB::beginTransaction();

            $this->b2xLoanRepository->updateById($loanId, $data);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(
                response()->json([
                    'success' => false,
                    'message' => localize("Loan update error"),
                    'title'   => localize('B2xLoan'),
                    'errors'  => $exception,
                ], 422)
            );
        }
    }

    public function checkLoan($attributes): ?object
    {
        $loanId     = $attributes['loan_id'];
        $customerId = $attributes['customer_id'];

        return $this->b2xLoanRepository->findDoubleWhereFirst('id', $loanId, 'customer_id', $customerId);
    }

    /**
     * Update loan status
     *
     * @param array $attributes
     * @return bool
     * @throws Exception
     */
    public function withdrawRequestUpdate(array $attributes): bool
    {
        $loanId = $attributes['loan_id'];

        $data['currency']           = $attributes['payment_currency'];
        $data['withdraw_status']    = $attributes['withdraw_status'];
        $data['payment_gateway_id'] = $attributes['payment_method'];

        try {
            DB::beginTransaction();

            $this->b2xLoanRepository->updateById($loanId, $data);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(
                response()->json([
                    'success' => false,
                    'message' => localize("Loan update error"),
                    'title'   => localize('B2xLoan'),
                    'errors'  => $exception,
                ], 422)
            );
        }
    }

    /**
     * Delete expense
     *
     * @param array $attributes
     * @return bool
     * @throws Exception
     */
    public function destroy(array $attributes): bool
    {
        $packageId = $attributes['package_id'];

        try {
            DB::beginTransaction();

            $this->packageRepository->destroyById($packageId);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(
                response()->json([
                    'success' => false,
                    'message' => localize("Package delete error"),
                    'title'   => localize('Package delete error'),
                    'errors'  => $exception,
                ], 422)
            );
        }
    }

}
