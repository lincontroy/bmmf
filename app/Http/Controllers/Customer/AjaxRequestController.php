<?php

namespace App\Http\Controllers\Customer;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\AcceptCurrencyRequest;
use App\Http\Resources\CustomerInfoResource;
use App\Models\AcceptCurrency;
use App\Models\Customer;
use App\Models\PaymentGateway;
use App\Rules\UserExists;
use App\Services\AcceptCurrencyService;
use App\Services\CustomerService;
use App\Services\FeeSettingService;
use App\Services\WithdrawalAccountService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class AjaxRequestController extends Controller
{
    use ResponseTrait;

    public function __construct(
        private AcceptCurrencyService $acceptCurrencyService,
        protected FeeSettingService $feeSettingService,
        private CustomerService $customerService,
        private WithdrawalAccountService $withdrawalAccountService
    ) {

    }

    /**
     * Find Accept currency by payment gateway Id
     * @param \App\Http\Requests\Customer\AcceptCurrencyRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function loadCurrency(AcceptCurrencyRequest $request): JsonResponse
    {
        $validateData = $request->validated();
        $gatewayId    = $validateData['gateway_id'];

        return $this->sendJsonResponse(
            'currency_load',
            StatusEnum::SUCCESS->value,
            Response::HTTP_OK,
            '',
            $this->acceptCurrencyService->findCurrency($gatewayId),
        );
    }

    public function loadFees(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'txn_type' => 'required|string|in:Deposit,Transfer,Withdraw',
            ]);
            $txnType = $validatedData['txn_type'];

            return $this->sendJsonResponse(
                'fees_load',
                StatusEnum::SUCCESS->value,
                Response::HTTP_OK,
                '',
                $this->feeSettingService->findFeeByLevel($txnType) ?? (object) [],
            );

        } catch (ValidationException $e) {
            return response()->json([
                'status'  => 'error',
                'message' => localize('Validation failed'),
                'errors'  => $e->validator->errors()->all(),
            ], 422);
        }

    }

    public function loadUser(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'user' => ['required', 'string', new UserExists],
            ]);

            $userData = $this->customerService->findCustomer($validatedData);

            if ($userData->id == auth()->user()->id) {
                return response()->json([
                    'status'  => 'error',
                    'message' => localize('Validation failed'),
                    'errors'  => [localize('You are not authorized to transfer to your own account.')],
                ], 422);
            }

            return $this->sendJsonResponse(
                'user_load',
                StatusEnum::SUCCESS->value,
                Response::HTTP_OK,
                '',
                new CustomerInfoResource($userData),
            );

        } catch (ValidationException $e) {
            return response()->json([
                'status'  => 'error',
                'message' => localize('Validation failed'),
                'errors'  => $e->validator->errors()->all(),
            ], 422);
        }

    }

    public function withdrawalAccount(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'gateway_id'      => ['required', 'integer', Rule::exists(PaymentGateway::class, 'id')],
                'currency_symbol' => ['required', 'string', Rule::exists(AcceptCurrency::class, 'symbol')],
            ]);

            $withdrawalAccountData = $this->withdrawalAccountService->findWithdrawalAccount([
                'payment_currency' => $validatedData['currency_symbol'],
                'payment_method'   => $validatedData['gateway_id'],
            ]);

            if (!$withdrawalAccountData) {
                return response()->json([
                    'status'  => 'error',
                    'message' => localize('Validation failed'),
                    'errors'  => [localize('You do not have a withdrawal account') .
                        '. Please add an account <a class="text-decoration-underline" href="' . route('customer.withdraw.account.create') . '" target="_blank">here</a>'],
                ], 422);
            }

            return $this->sendJsonResponse(
                'withdrawal_account',
                StatusEnum::SUCCESS->value,
                Response::HTTP_OK,
                '',
                $withdrawalAccountData->credentials,
            );

        } catch (ValidationException $e) {
            return response()->json([
                'status'  => 'error',
                'message' => localize('Validation failed'),
                'errors'  => $e->validator->errors()->all(),
            ], 422);
        }

    }

}
