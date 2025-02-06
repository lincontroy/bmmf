<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Services\AcceptCurrencyService;
use App\Services\WalletTransactionLogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Modules\Customer\App\Http\Requests\CustomerRequest;

class WalletManageController extends Controller
{
    /**
     * WalletManageController of __construct
     *
     * @param AcceptCurrencyService $acceptCurrencyService
     * @param WalletTransactionLogService $transactionLogService
     */
    public function __construct(
        protected AcceptCurrencyService $acceptCurrencyService,
        protected WalletTransactionLogService $walletTransactionLogService,
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): view
    {
        cs_set('theme', [
            'title'       => localize('Wallet Manage'),
            'description' => localize('Wallet Manage'),
        ]);

        $attributes['user_id'] = Auth::user()->user_id;
        $wallets               = $this->acceptCurrencyService->allWithBalance($attributes);
        $transactionLogs       = $this->walletTransactionLogService->userTransactionLogs($attributes);

        return view('customer.wallet.index', compact('wallets', 'transactionLogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customer::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerRequest $request): JsonResponse
    {
        $user = $this->customerService->customerCreate($request->all());

        return response()->json([
            'success' => true,
            'message' => localize("Customer create successfully"),
            'title'   => localize("Customer"),
            'data'    => $user,
        ]);
    }

    /**
     * Show the specified resource.
     */
    public function show(int $id)
    {
        cs_set('theme', [
            'title'       => localize('Wallet Manage Detail'),
            'description' => localize('Wallet Manage Detail'),
        ]);

        $customer = $this->customerService->findOrFail($id);

        $attributes['customer_id'] = $id;
        $attributes['user_id']     = $customer['user_id'];

        $deposits    = $this->depositService->getAll($attributes);
        $withdraws   = $this->withdrawService->getAll($attributes);
        $transfers   = $this->transferService->getAllReceived($attributes);
        $received    = $this->transferService->getAllTransfer($attributes);
        $investments = $this->investmentService->getAllInvestments($attributes);

        return view('customer::customer.details', compact('deposits', 'withdraws', 'transfers', 'received', 'investments', 'customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $user = $this->customerService->findOrFail($id);

        return view('customer::customer.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     * @param CustomerRequest $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(CustomerRequest $request, $id): JsonResponse
    {
        $data                = $request->validated();
        $data['customer_id'] = $id;
        $user                = $this->customerService->update($data);

        return response()->json([
            'success' => true,
            'message' => localize("Customer update successfully"),
            'title'   => localize("Customer"),
            'data'    => $user,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @param Request $request
     * @var int $id
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $this->customerService->destroy(['cust_id' => $id]);

        return response()->json([
            'success' => true,
            'message' => localize("Customer delete successfully"),
            'title'   => localize("Customer"),
        ]);
    }

}
