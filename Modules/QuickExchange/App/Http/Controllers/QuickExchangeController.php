<?php

namespace Modules\QuickExchange\App\Http\Controllers;

use App\Enums\PermissionActionEnum;
use App\Enums\PermissionMenuEnum;
use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Services\CoinMarketCapService;
use App\Traits\ChecksPermissionTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Modules\QuickExchange\App\DataTables\QuickExchangeCoinDataTable;
use Modules\QuickExchange\App\DataTables\QuickExchangeOrderRequestDataTable;
use Modules\QuickExchange\App\DataTables\QuickExchangeTransactionDataTable;
use Modules\QuickExchange\App\Http\Requests\QuickExchangeAddCoinRequest;
use Modules\QuickExchange\App\Http\Requests\QuickExchangeTransactionVerifyRequest;
use Modules\QuickExchange\App\Services\QuickExchangeService;

class QuickExchangeController extends Controller
{
    use ChecksPermissionTrait;

    public $mapActionPermission;

    public function __construct(
        private CoinMarketCapService $coinMarketCapService,
        private QuickExchangeService $quickExchangeService
    ) {
        $this->mapActionPermission = [
            'index'             => PermissionMenuEnum::QUICK_EXCHANGE_SUPPORTED_COIN->value . '.' . PermissionActionEnum::READ->value,
            'create'            => PermissionMenuEnum::QUICK_EXCHANGE_SUPPORTED_COIN->value . '.' . PermissionActionEnum::CREATE->value,
            'store'             => PermissionMenuEnum::QUICK_EXCHANGE_SUPPORTED_COIN->value . '.' . PermissionActionEnum::CREATE->value,
            'show'              => PermissionMenuEnum::QUICK_EXCHANGE_SUPPORTED_COIN->value . '.' . PermissionActionEnum::READ->value,
            'edit'              => PermissionMenuEnum::QUICK_EXCHANGE_SUPPORTED_COIN->value . '.' . PermissionActionEnum::UPDATE->value,
            'update'            => PermissionMenuEnum::QUICK_EXCHANGE_SUPPORTED_COIN->value . '.' . PermissionActionEnum::UPDATE->value,
            'transactionUpdate' => PermissionMenuEnum::QUICK_EXCHANGE_SUPPORTED_COIN->value . '.' . PermissionActionEnum::UPDATE->value,
            'destroy'           => PermissionMenuEnum::QUICK_EXCHANGE_SUPPORTED_COIN->value . '.' . PermissionActionEnum::DELETE->value,
            'request'           => PermissionMenuEnum::QUICK_EXCHANGE_ORDER_REQUEST->value . '.' . PermissionActionEnum::READ->value,
            'transaction'       => PermissionMenuEnum::QUICK_EXCHANGE_TRANSACTION_LIST->value . '.' . PermissionActionEnum::READ->value,
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(QuickExchangeCoinDataTable $quickExchangeCoinDataTable)
    {
        cs_set('theme', [
            'title'       => localize('Quick Exchange Coin'),
            'description' => localize('Quick Exchange Coin'),
        ]);

        return $quickExchangeCoinDataTable->render('quickexchange::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        cs_set('theme', [
            'title'       => localize('Base Currency'),
            'description' => localize('Base Currency'),
        ]);

        $data['baseCoin'] = $this->quickExchangeService->baseCoin();

        return view('quickexchange::create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuickExchangeAddCoinRequest $request): JsonResponse
    {
        $validateData = $request->validated();

        if (!isset($validateData['coinType'])) {
            $coinExists = $this->coinMarketCapService->coinExists($validateData['symbol']);

            if (!$coinExists) {
                return response()->json([
                    'success' => false,
                    'message' => localize("Invalid Coin Symbol! It must be listed on CoinMarketCap."),
                    'title'   => localize("Add Coin"),
                    'data'    => [],
                ]);
            }

        }

        $createData = $this->quickExchangeService->createCoin($validateData);
        return response()->json([
            'success' => true,
            'message' => localize("Coin created successfully"),
            'title'   => localize("Quick Exchange Coin"),
            'data'    => $createData,
        ]);
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $data['quickExchangeRequest'] = $this->quickExchangeService->findTransaction(['id' => $id]);

        return view('quickexchange::show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $data['quickExchangeCoin'] = $this->quickExchangeService->find(['id' => $id]);

        return view('quickexchange::edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(QuickExchangeAddCoinRequest $request, $id): JsonResponse
    {
        $validateData = $request->validated();

        if (!isset($validateData['coinType'])) {
            $coinExists = $this->coinMarketCapService->coinExists($validateData['symbol']);

            if (!$coinExists) {
                return response()->json([
                    'success' => false,
                    'message' => localize("Invalid Coin Symbol! It must be listed on CoinMarketCap."),
                    'title'   => localize("Add Coin"),
                    'data'    => [],
                ]);
            }

        }

        $updateData = $this->quickExchangeService->update($validateData, $id);

        return response()->json([
            'success' => true,
            'message' => localize("Updated successfully"),
            'title'   => localize("Coin"),
            'data'    => $updateData,
        ]);
    }

    public function transactionUpdate(QuickExchangeTransactionVerifyRequest $request): JsonResponse
    {
        $validateData = $request->validated();
        $updateData   = $this->quickExchangeService->transactionUpdate($validateData, $request->get('id'));

        if ($updateData) {

            if ($validateData['transactionStatus'] == StatusEnum::ACTIVE->value) {
                $msg = localize("Transaction completed successfully!");
            } else {
                $msg = localize("Transaction rejected successfully!");
            }

            return response()->json([
                'success' => true,
                'message' => $msg,
                'title'   => localize("Transaction"),
                'data'    => [],
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => localize("Updated failed! something went wrong!"),
                'title'   => localize("Transaction"),
                'data'    => [],
            ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->quickExchangeService->destroy(['coin_id' => $id]);

        return response()->json([
            'success' => true,
            'message' => localize("Deleted successfully"),
            'title'   => localize("Coin"),
        ]);
    }

    /**
     * Quick Exchange Order List
     * @param \Modules\QuickExchange\App\DataTables\QuickExchangeOrderRequestDataTable $quickExchangeOrderRequestDataTable
     * @return mixed
     */
    public function request(QuickExchangeOrderRequestDataTable $quickExchangeOrderRequestDataTable)
    {
        cs_set('theme', [
            'title'       => localize('Order Request'),
            'description' => localize('Quick Exchange Order Request'),
        ]);

        return $quickExchangeOrderRequestDataTable->render('quickexchange::request');
    }

    /**
     * Quick Exchange Transaction List
     * @param \Modules\QuickExchange\App\DataTables\QuickExchangeOrderRequestDataTable $quickExchangeOrderRequestDataTable
     * @return mixed
     */
    public function transaction(QuickExchangeTransactionDataTable $quickExchangeTransactionDataTable)
    {
        cs_set('theme', [
            'title'       => localize('Transaction List'),
            'description' => localize('Transaction List'),
        ]);

        return $quickExchangeTransactionDataTable->render('quickexchange::transaction');
    }

}
