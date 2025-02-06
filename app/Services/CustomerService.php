<?php

namespace App\Services;

use App\Mail\UserWelcomeEmail;
use App\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Repositories\Interfaces\TxnReportRepositoryInterface;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CustomerService
{
    /**
     * CustomerService constructor.
     *
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct(
        protected CustomerRepositoryInterface $customerRepository,
        protected TxnReportRepositoryInterface $txnReportRepository
    ) {
    }

    /**
     * Find customer by id
     *
     * @param int $id
     * @return array
     */
    public function findOrFail(int $id): ?object
    {
        return $this->customerRepository->findOrFail($id);
    }

    /**
     * Find Customer or throw 404
     *
     * @param  int  $id
     * @return object
     */
    public function findByAttributes(array $attribute): object
    {
        return $this->customerRepository->findByAttributes($attribute);
    }

    /**
     * Create Customer
     *
     * @param array $attributes
     * @return array
     * @throws Exception
     */
    public function create(array $attributes): object
    {
        try {
            DB::beginTransaction();

            $user = $this->customerRepository->create($attributes);

            // Define URL and message
            $url        = url('account/active?token=' . $user->email_verification_token);
            $welcomeMsg = 'Your account was created successfully, Please click on the link below to activate your account.';

            // Send welcome email
            Mail::to($user->email)->send(new UserWelcomeEmail($url, $welcomeMsg));

            DB::commit();

            return $user;
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

    /**
     * Customer Verify Status Update
     *
     * @param array $attributes
     * @return bool
     * @throws Exception
     */
    public function updateVerifyStatusById(array $attributes): bool
    {
        $customerID = $attributes['customer_id'];

        try {
            DB::beginTransaction();

            $this->customerRepository->updateVerifyStatusById($customerID, $attributes);

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

    /**
     * Customer Site Align Update
     *
     * @param array $attributes
     * @return bool
     * @throws Exception
     */
    public function updateSiteAlign(array $attributes): bool
    {
        $customerID = $attributes['customer_id'];

        try {
            DB::beginTransaction();

            $this->customerRepository->updateSiteAlignById($customerID, $attributes);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(redirect()->back()->withErrors($exception));
        }
    }

    /**
     * Create Customer
     *
     * @param array $attributes
     * @return array
     * @throws Exception
     */
    public function customerCreate(array $attributes): object
    {

        try {
            DB::beginTransaction();

            $user = $this->customerRepository->customerCreate($attributes);

            DB::commit();

            return $user;
        } catch (Exception $exception) {
            DB::rollBack();

            throw $exception;
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
        $custId = $attributes['customer_id'];

        try {
            DB::beginTransaction();

            $this->customerRepository->destroyById($custId);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(
                response()->json([
                    'success' => false,
                    'message' => localize("Customer delete error"),
                    'title'   => localize('Customer delete error'),
                    'errors'  => $exception,
                ], 422)
            );
        }
    }

    /**
     * Customer Report data
     * @return object
     */
    public function report(): object
    {
        $totalCustomers        = $this->customerRepository->count();
        $currentMonthCustomer  = $this->customerRepository->countCurrentMonthCustomer();
        $previousMonthCustomer = $this->customerRepository->countPreviousMonthCustomer();
        $percentageDifference  = $previousMonthCustomer > 0 ? ($currentMonthCustomer - $previousMonthCustomer) / $previousMonthCustomer * 100 : ($currentMonthCustomer - $previousMonthCustomer > 0 ? 100 : 0);

        return (object) [
            'totalCustomer'         => $totalCustomers,
            'currentMonthCustomer'  => $currentMonthCustomer,
            'previousMonthCustomer' => $previousMonthCustomer,
            'percentageDifference'  => number_format($percentageDifference, 2, '.', ''),
        ];
    }

    /**
     * Fetch yearly chart data
     * @return object
     */
    public function customerChartData(): object
    {
        $chartYearData = $this->customerRepository->countYearlyCustomer();

        return (object) [
            'abbreviateMonthNames' => getAbbreviatedMonthNames(),
            'chartYearData'        => $chartYearData,
        ];
    }

    public function findCustomer(array $attributes): ?object
    {
        return $this->customerRepository->findCustomer($attributes);
    }
}
